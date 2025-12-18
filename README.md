 # ISTA PV — Procès-Verbaux Manager

 This repository contains a scaffold for a secure, responsive web application to manage and archive "Procès-Verbaux de Fin de Formation" (PV) and related documents for ISTA Ouarzazate.

 This repository currently includes two scaffolds:
 - `ista_pv_laravel/` — Primary Laravel scaffold (recommended).
 - `ista_pv/` — Django scaffold (legacy/alternate). This folder is optional and can be removed if you choose to use Laravel only.

 This top-level README explains the project, how to set up the Laravel application (recommended path), how to run basic commands, security notes, and a safe, optional cleanup script to remove the legacy Django scaffold and other optional files.

 ---

 ## Quick overview

 - Role-based authentication with roles: `admin`, `manager`, `consultant`, `archivist` (Laravel scaffold uses a `role` column in `users`).
 - PV CRUD (create/list/detail), file upload handling for PV documents and student copies.
 - Organized file storage by `Year/Level/Department/Group`.
 - Audit logs to track user actions.
 - Bulk import (CSV/XLSX) scaffolded (file upload and parsing stubs).
 - API-ready routes can be added later (recommended for integrations).

 ---

 ## File / Folder layout (current)

 - `ista_pv_laravel/` — Laravel scaffold
   - `app/Models/` — Eloquent models: `PV`, `PVDocument`, `StudentCopy`, `AuditLog`
   - `app/Http/Controllers/PVController.php` — PV controller and upload endpoints
   - `app/Http/Middleware/RoleMiddleware.php` — simple RBAC middleware
   - `database/migrations/` — migrations for tables and `role` column for `users`
   - `database/seeders/AdminUserSeeder.php` — create initial admin user (email `admin@example.com` / password `ChangeMe123!`)
   - `resources/views/pvs/` — Blade templates (index, show, create, import)
   - `routes/web.php` — web routes (includes upload routes protected by `role` middleware)

 - `ista_pv/` — Django scaffold (legacy). If you plan to use Laravel only you can delete or archive this folder.

 - Root files:
   - `.gitignore` — git ignore rules
   - `README.md` (this file)
   - `ista_pv_laravel/README.md` — additional Laravel scaffold notes
   - `ista_pv/README.md` — additional Django scaffold notes (optional)

 ---

 ## How to run the Laravel scaffold (development)

 1. Create a new Laravel project (if you prefer a full Laravel app) or use this scaffold as the app root. From Windows PowerShell:

 ```powershell
 # from a directory where you want the app
 # If you need a fresh Laravel project (recommended):
 composer create-project laravel/laravel ista_pv_laravel_app
 cd ista_pv_laravel_app

 # Copy contents of this repository's 'ista_pv_laravel' into the Laravel project (merge folders)
 # Or use this scaffold directory directly as your project root.
 ```

 2. Install dependencies and scaffold auth UI:

 ```powershell
 composer require laravel/ui --dev
 php artisan ui bootstrap --auth
 npm install
 npm run dev
 ```

 3. Configure `.env` (copy the scaffold `.env.example` into `.env` and set DB creds) and generate app key:

 ```powershell
 copy .env.example .env
 php artisan key:generate
 ```

 4. Run migrations and seed initial admin user:

 ```powershell
 php artisan migrate
 php artisan db:seed --class=\Database\Seeders\AdminUserSeeder
 php artisan storage:link
 php artisan serve
 ```

 5. Visit `http://127.0.0.1:8000` and log in with the seeded credentials (change password immediately):

 - Email: `admin@example.com`
 - Password: `ChangeMe123!`

 ---

 ## Notes about the Django scaffold

 The repository also contains a Django scaffold in `ista_pv/`. It's a mostly working scaffold with models, DRF viewsets, templates, and a `daily_backup` management command. I left it in the repo in case you want a Python implementation.

 If you choose to use Laravel only, you can safely remove the `ista_pv/` folder. See the optional cleanup script below.

 ---

 ## Security & production recommendations

 - Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
 - Use PostgreSQL for production if possible.
 - Use S3 (or Azure Blob) for file storage and keep media outside the app container.
 - Enforce strong file validation and run virus scanning (ClamAV or commercial service) on uploads before storing.
 - Use HTTPS and set HSTS headers.
 - Use field-level encryption for personally identifiable information (PII).
 - Configure daily backups (push to remote storage) and retention policy — don't rely on local zips for production.

 ---

 ## What I fixed and what I recommend next

 - Implemented: Laravel scaffold, RBAC middleware, PV models, upload endpoints, Blade templates, DB migrations, seeder, and pushed to `origin/main`.
 - Recommended next steps (priority order):
   1. Complete Laravel auth (run `php artisan ui bootstrap --auth` or use Jetstream/Breeze).
   2. Harden file upload (virus scanning, content-type checks, size limits), and move file storage to S3.
   3. Implement queued import job (Redis + queue worker) for large CSV/XLSX imports.
   4. Add REST API controllers and authentication tokens (Laravel Sanctum or Passport).
   5. Add full test suite (PHPUnit + Laravel Dusk for browser flows).
   6. Configure CI (GitHub Actions) to run tests and linting.

 ---

 ## Optional cleanup (non-destructive) — what I can delete for you

 If you want me to remove optional files (for a cleaner repo), I prepared a PowerShell script you can run locally. It will delete the `ista_pv/` Django scaffold and other optional items.

 Run the script only if you understand it will permanently remove files from your working directory:

 ```powershell
 # from repo root
 powershell -ExecutionPolicy Bypass -File .\scripts\cleanup-optional.ps1
 ```

 The script will remove:
 - `ista_pv/` (Django scaffold)
 - `ista_pv\requirements.txt` and other Django-only helper files

 It will not modify the `ista_pv_laravel/` folder unless you adjust the script.

 ---

 ## Contributing

 - Branch from `main` and open PRs. I'll continue implementing feature branches for import parsing, API endpoints, and tests, and will push those to `main` when complete (or to feature branches if you prefer PR review).


