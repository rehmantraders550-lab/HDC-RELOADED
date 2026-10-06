# Hadi Digital Craft — PHP/MySQL application

A responsive, server-rendered PHP 8.2 + MySQL/MariaDB website foundation based on the HDC system brief and ORVIA product copy. It includes a public home/catalogue/product/quote journey, a password-protected admin review desk, private artwork intake, quote and job tracking/export, migrations, seed data, and exact-price lookup rules.

## Requirements

- PHP 8.2+ with `pdo_mysql`, `mbstring`, `fileinfo`, and `openssl`
- MySQL 8 or MariaDB 10.6+
- Apache with `mod_rewrite` (or equivalent rewrite rules)
- No Composer or JavaScript build step

## Local setup

See [`docs/SETUP.md`](docs/SETUP.md). The website document root must point to `public/`. Keep `.env` and `storage/` outside the public document root.

## Source data and approvals

- `app/products.json` carries the 19 product descriptions from the ORVIA draft. The seed adds the owner-confirmed catalogue product. All 20 records start as drafts and hidden.
- `database/001_schema.sql` holds product, approved profile, exact price matrix, quote, audit, and private artwork metadata tables.
- `CommercialRules` enforces the 500-piece catalogue/poster MOQ, 1/2/4 color values, exact approved price lookup, and the PKR 2,500 A3 sticker/label sheet base price without multiplying it into a total.
- UV printing and UV DTF are recorded as commonly used process guidance; no product-specific process or surface compatibility is approved by that note.
- Product listing requires separate production approval, public visibility approval, and published status.
- Quote intake accepts up to five PDF, PNG, JPEG, TIFF, or EPS files (25 MB each by default). Uploads receive MIME/size checks, random storage names, private permissions, and admin-authenticated downloads. Configure `UPLOAD_DIR` to a writable location outside `public/`.

## Available routes

- `/` — home and approved service index
- `/services` and `/services/{slug}` — four HDC service territories
- `/products` and `/products/{slug}` — approved catalogue pages
- `/finishing`, `/surface-lab`, `/about`, `/faq` — supporting service and process content
- `/quote` — quote request capture
- `/admin/login` and `/admin` — request tracking, private artwork downloads, quote/job workflow, CSV export, catalogue/profile review, exact price rows

## Verification status

Node.js can run the catalogue data contract checks in this folder. PHP, MySQL/MariaDB, and Docker were unavailable in the authoring environment, so migration, login, quote persistence, and browser behavior require runtime verification in the setup environment before deployment.
