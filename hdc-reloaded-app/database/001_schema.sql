CREATE TABLE IF NOT EXISTS schema_migrations (
  migration VARCHAR(190) PRIMARY KEY,
  applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS admin_users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS products (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(190) NOT NULL UNIQUE,
  name VARCHAR(190) NOT NULL,
  family VARCHAR(120) NOT NULL,
  short_description TEXT NOT NULL,
  description MEDIUMTEXT NOT NULL,
  typical_uses TEXT NULL,
  configuration_fields TEXT NULL,
  template VARCHAR(20) NOT NULL DEFAULT 'A',
  commercial_mode VARCHAR(32) NOT NULL DEFAULT 'QUOTE',
  status ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
  public_visibility TINYINT(1) NOT NULL DEFAULT 0,
  production_approved TINYINT(1) NOT NULL DEFAULT 0,
  approved_by BIGINT UNSIGNED NULL,
  approved_at TIMESTAMP NULL,
  approval_note VARCHAR(1000) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  source_metadata JSON NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX product_publication_idx(status,public_visibility,sort_order),
  FOREIGN KEY (approved_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS configuration_profiles (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id BIGINT UNSIGNED NOT NULL,
  profile_json JSON NOT NULL,
  approved TINYINT(1) NOT NULL DEFAULT 0,
  approved_by BIGINT UNSIGNED NULL,
  approved_at TIMESTAMP NULL,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (approved_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS price_matrix (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id BIGINT UNSIGNED NOT NULL,
  configuration_hash CHAR(64) NOT NULL,
  price_pkr DECIMAL(12,2) NOT NULL,
  approved TINYINT(1) NOT NULL DEFAULT 0,
  approved_by BIGINT UNSIGNED NULL,
  approved_at TIMESTAMP NULL,
  UNIQUE KEY exact_price_row(product_id,configuration_hash),
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (approved_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS owner_price_rules (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_slug VARCHAR(190) NOT NULL,
  rule_key VARCHAR(100) NOT NULL,
  rule_json JSON NOT NULL,
  source VARCHAR(190) NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY owner_rule(product_slug,rule_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS quote_requests (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(60) NULL,
  details TEXT NOT NULL,
  status ENUM('new','in_review','awaiting_customer','quoted','closed') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX quote_status_date(status,created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS quote_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  quote_id BIGINT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NULL,
  configuration_json JSON NULL,
  matched_price_pkr DECIMAL(12,2) NULL,
  evaluation_json JSON NULL,
  FOREIGN KEY (quote_id) REFERENCES quote_requests(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS artwork_files (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  quote_id BIGINT UNSIGNED NOT NULL,
  storage_key VARCHAR(255) NOT NULL,
  original_name VARCHAR(255) NOT NULL,
  mime_type VARCHAR(120) NOT NULL,
  byte_size BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (quote_id) REFERENCES quote_requests(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS audit_events (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  admin_id BIGINT UNSIGNED NULL,
  event_type VARCHAR(80) NOT NULL,
  entity_type VARCHAR(80) NOT NULL,
  entity_id BIGINT UNSIGNED NULL,
  details_json JSON NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE SET NULL,
  INDEX audit_entity(entity_type,entity_id,created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS product_process_guidance (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  process_code ENUM('UV_PRINT','UV_DTF') NOT NULL UNIQUE,
  owner_note VARCHAR(500) NOT NULL,
  common_use TINYINT(1) NOT NULL DEFAULT 1,
  approved_product_specific TINYINT(1) NOT NULL DEFAULT 0,
  source VARCHAR(190) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS quote_rate_limits (
  bucket_hash CHAR(64) PRIMARY KEY,
  request_count INT UNSIGNED NOT NULL DEFAULT 0,
  window_started_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS jobs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  quote_id BIGINT UNSIGNED NOT NULL UNIQUE,
  job_reference VARCHAR(80) NOT NULL UNIQUE,
  status ENUM('awaiting_customer_approval','approved','in_production','quality_check','ready','completed','on_hold','cancelled') NOT NULL DEFAULT 'awaiting_customer_approval',
  specification_snapshot JSON NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (quote_id) REFERENCES quote_requests(id) ON DELETE RESTRICT,
  INDEX job_status_updated(status,updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
