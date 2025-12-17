# ISTA PV Manager (Laravel scaffold)

This folder contains a minimal scaffold (routes, controller stubs, model, migration and Blade templates) to integrate into a full Laravel application.

Recommended steps to create a working Laravel project (Windows PowerShell):

```powershell
# 1. Create a new Laravel project using Composer
composer create-project laravel/laravel ista_pv_laravel_app
cd ista_pv_laravel_app

# 2. Copy the scaffold files from this folder into the Laravel project (merge into app/, routes/, resources/, database/)
# e.g. copy or move files provided in c:\Users\Dell\Desktop\New folder (2)\ista_pv_laravel into the new project

# 3. Install dependencies and build
composer install
php artisan key:generate

# 4. Configure .env with DB credentials and set APP_URL
# 5. Run migrations
php artisan migrate

# 6. Create storage link for public file access
php artisan storage:link

# 7. Run the app
php artisan serve
```

Provided in this scaffold:
- `routes/web.php` : routes for PV list, detail and import
- `app/Http/Controllers/PVController.php` : controller stub for PV features
- `app/Models/PV.php` : simple Eloquent model
- `database/migrations/2025_12_17_000000_create_pvs_table.php` : migration for `pvs` table
- Blade templates in `resources/views/pvs/` for list, show, import forms; `resources/views/layouts/app.blade.php` base layout

Next steps I can do for you:
- Integrate authentication (roles and middleware)
- Add file upload handling, validations and storage policies
- Implement bulk import parsing (CSV/Excel) and dry-run reporting
- Add API controllers (for future integrations) and export features

Notes to finish integration:
- Register the `RoleMiddleware` in `app/Http/Kernel.php` under `$routeMiddleware`:

	'role' => \App\Http\Middleware\RoleMiddleware::class,

- Run migrations to create the new tables (pvs, pv_documents, student_copies, audit_logs, user role column):

	php artisan migrate

- Auth scaffolding: run `composer require laravel/ui --dev` and `php artisan ui bootstrap --auth` (or use Jetstream) to provide login/register/password reset UI.

- After auth is available, you can protect routes using middleware like `->middleware('role:admin,manager,archivist')` to restrict uploads and edits.

Git remote (done by assistant when pushing):

	git remote add origin https://github.com/Ki-sra/PV.git

When I finish local changes I will attempt to push to the above remote.

Tell me if you want me to copy these scaffold files into an existing Laravel project or to continue implementing full server-side logic now.
