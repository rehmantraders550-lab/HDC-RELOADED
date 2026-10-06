# Local and Hostinger setup

## 1. Install the runtime

Use PHP 8.2 or newer with `pdo_mysql`, `mbstring`, `fileinfo`, and `openssl`. Use MySQL 8 or MariaDB 10.6+. Apache `mod_rewrite` is needed for the included routes. No Composer packages or Node build are required for the website.

For a local development environment, XAMPP, Laragon, or a PHP/MySQL Docker setup can provide PHP and MariaDB. Use a separate local database and a disposable admin password.

## 2. Create the database and credentials

Create an empty utf8mb4 database and a restricted application user with privileges on that database. Do not use the database root account for the site.

```sql
CREATE DATABASE hdc_printing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hdc_user'@'localhost' IDENTIFIED BY 'use-a-unique-generated-password';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, REFERENCES ON hdc_printing.* TO 'hdc_user'@'localhost';
```

Adapt the host and permissions to your provider's database panel.

## 3. Configure the app

Copy `.env.example` to `.env`. Fill in the database host/name/user/password and set `APP_URL` and a random `APP_KEY` of at least 32 characters. Keep `.env` private and out of GitHub. Do not paste production credentials into chat, tickets, or commits.

The quote form accepts artwork files and stores them outside the `public/` document root by default at `storage/private-artwork/`. Keep that directory private and writable by PHP. If the host requires a different path, set `UPLOAD_DIR` to an absolute private directory or an app-root-relative directory outside `public/`; the admin download route reads from this same configured location.

## 4. Run migrations and seed data

From the application directory:

```sh
php bin/migrate.php
php bin/seed.php
php bin/create-admin.php your-admin@example.com
```

The admin command prompts for a hidden 14-character-minimum password. Run the seed only after the migration. It safely updates the catalogue but preserves existing publication status and approval flags. It leaves all product records hidden and in draft status. Price matrices and product-specific production profiles are empty until HDC confirms them.

## 5. Configure Apache / Hostinger

Deploy the contents of this app folder and set the website document root to its `public/` folder. The `.htaccess` file handles route rewriting and directory listing is disabled. If the selected Hostinger plan does not allow a custom document root, ask Hostinger support to set it or use a layout where only `public/` is web-accessible; do not expose `.env`, `database/`, `bin/`, or `storage/` over HTTP.

Set the correct PHP version and enable the extensions listed above. Add HTTPS before collecting quote requests. Confirm the host can connect to the database using the provider's database hostname.

## 6. First administrator review

Sign in at `/admin/login`. Review each product’s short/detail copy, intended audience, configuration, process and material support. A product is listed publicly only after the admin records a valid JSON production profile, production approval, public visibility approval, and published status. Each profile save creates an approval snapshot; the public route checks for an approved profile. Confirm that DTF transfers and finished DTF apparel belong in HDC’s public offer before approving their visibility.

Catalogues and posters require at least 500 pieces and 1, 2 or 4 print colors. Their actual prices require exact approved price-matrix rows. An A3 sticker or label sheet is recorded at PKR 2,500 per sheet as a base price; it is not automatically multiplied into a quote total. UV and UV DTF usage guidance is not product-specific approval.

## 7. Before launch

Runtime checks still required: PHP syntax, migration/seed against the selected MySQL/MariaDB version, hidden admin creation, successful/failed login, CSRF rejection, quote persistence and status update, publication gating, exact price lookup, HTTPS cookie behavior, and keyboard/mobile browser checks. Price rows are entered as canonical JSON through the admin matrix form; all submitted configuration fields must match the approved row exactly. Before relying on the quote inbox in production, run the documented runtime checks, verify upload limits and private-directory permissions, and configure the required notification, retention, and backup policies. Quote rate limiting and private artwork handling are implemented, but still require runtime verification on the target host. If a database save fails after private files are stored, those files are retained for administrator review; automated cleanup is intentionally disabled.

## Artwork intake settings

The quote form accepts up to five PDF, PNG, JPEG, TIFF, or EPS files (25 MB each by default). PHP must have `fileinfo`; set `upload_max_filesize` to at least `25M` and `post_max_size` to at least `130M`. The app checks the actual MIME type, creates random storage names, sets private file permissions, and stores only file metadata and references in MySQL. Files stay outside `public/`. Admin downloads require an authenticated session and are sent as attachments with `nosniff`; downloads are audited. Set `UPLOAD_DIR` to a private writable folder outside the document root when the hosting layout requires a custom location; both upload storage and authenticated downloads use this configured path. Do not enable public artwork previews.

Admin quote export is a private CSV download. The review desk can update request status and create a separate job record after a request has been marked `quoted`. Job records begin with customer approval pending; status changes are audited. CSV export includes quote and current job state.
