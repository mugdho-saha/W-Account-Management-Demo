# W Account Management (Demo)

A Laravel web application for **double-entry style bookkeeping**: users record **transactions** between **categories** (debit and credit sides), view a **dashboard**, and run **reports** (date-range listings and balance sheet) with **PDF export**. Access is controlled with **roles** (admin, moderator, observer).

---

## What the application does

| Area | Behavior |
|------|----------|
| **Authentication** | Register, login, logout, password reset, and email verification (must verify email before using the app). |
| **Users** | Admins create and manage users and assign **roles**. |
| **Categories** | Admins maintain categories used on transactions. Each category has a **type** (`asset`, `liability`, `equity`) used for the balance sheet. Categories can be linked to users via a pivot table. |
| **Transactions** | Moderators and admins add, edit, and delete transactions: date, description, amount, **debit category**, **credit category**, and owning user. |
| **Dashboard** | Admins and observers see a summary dashboard. |
| **Reports** | All verified users can open date-wise transaction reports and balance sheet views; selected flows download **PDF** (DomPDF). |
| **Profile** | Any verified user can update profile information, password, or delete their account. |

After login, **moderators** are redirected to the transactions list; **everyone else** goes to the dashboard (`bootstrap/app.php`).

---

## Tech stack

- **PHP** 8.2+, **Laravel** 12  
- **MySQL** (default in `.env.example`; adjust as needed)  
- **Laravel Breeze**-style auth (Blade + Tailwind + Vite)  
- **Spatie Laravel Permission** — roles  
- **Spatie Laravel Activity Log** — category change history  
- **Barryvdh Laravel DomPDF** — PDF reports  

Front-end assets: **Vite**, **Tailwind CSS**, **Alpine.js**.

---

## Prerequisites

- PHP 8.2+ with common extensions (mbstring, openssl, pdo, etc.)  
- Composer  
- Node.js and npm  
- MySQL (or another database supported by Laravel, after driver/config changes)

---

## Local setup

1. **Clone** the repository and enter the project directory.

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Environment**

   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

   Edit `.env` and set `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, and `APP_URL` to match your machine.

4. **Database**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

   Seeding creates roles, a demo admin user, sample categories, and sample transactions (see `database/seeders/DatabaseSeeder.php` for order).

5. **Front-end**

   ```bash
   npm install
   npm run build
   ```

   For development with hot reload:

   ```bash
   npm run dev
   ```

6. **Run the app**

   ```bash
   php artisan serve
   ```

   Or use the Composer script that runs the server, queue listener, and Vite together: `composer run dev` (see `composer.json`).

---

## Seeded admin user (demo)

Created by `AdminUserSeeder`:

| Field | Value |
|-------|--------|
| Email | `admin@test.com` |
| Password | `password123` |

Change this password immediately in any non-demo environment.

---

## Roles and route access

Roles are defined in `database/seeders/RolePermissionSeeder.php`: `admin`, `moderator`, `observer`.

| Role | Typical access |
|------|----------------|
| **admin** | Users, categories, transactions, dashboard, reports, profile |
| **moderator** | Transactions (after login redirect), reports, profile — **not** user/category admin or dashboard route |
| **observer** | Dashboard, reports, profile — **not** users, categories, or transactions |

Exact HTTP routes and middleware live in `routes/web.php` (authenticated + `verified` + optional `role:…`).

---

## Project map for developers

Use this table to find where features live. Paths are from the repository root.

| Topic | Location | Notes |
|-------|----------|--------|
| **Web routes (app + roles)** | `routes/web.php` | Main application URLs and middleware groups. |
| **Auth routes** | `routes/auth.php` | Login, register, verification, password flows; included from `web.php`. |
| **Console** | `routes/console.php` | Scheduled commands / Artisan closures if added. |
| **Role middleware aliases** | `bootstrap/app.php` | `role`, `permission`, `role_or_permission` (Spatie); post-login redirect for moderators. |
| **User CRUD** | `app/Http/Controllers/UserController.php` | Backed by `App\Models\User`. |
| **Categories** | `app/Http/Controllers/CategoryController.php` | `App\Models\Category` — activity logging configured on the model. |
| **Transactions** | `app/Http/Controllers/TransactionController.php` | `App\Models\Transaction` — debit/credit categories and user. |
| **Dashboard** | `app/Http/Controllers/DashboardController.php` | `resources/views/dashboard.blade.php` |
| **Reports & PDFs** | `app/Http/Controllers/ReportController.php` | Views under `resources/views/reports/` (`datewise`, `balancesheet`, `pdf_*`). |
| **Profile** | `app/Http/Controllers/ProfileController.php` | `resources/views/profile/` + partials. |
| **Auth UI & logic** | `app/Http/Controllers/Auth/*.php` | Breeze-style controllers. |
| **Form requests** | `app/Http/Requests/` | e.g. `ProfileUpdateRequest`, `Auth/LoginRequest`. |
| **Blade layouts** | `resources/views/layouts/` | `app.blade.php`, `guest.blade.php`, `theme.blade.php`, `navigation.blade.php`. |
| **Theme / navigation** | `resources/views/components/theme/` | Sidebar, header, footer. |
| **Domain models** | `app/Models/` | `User`, `Category`, `Transaction`. |
| **Migrations** | `database/migrations/` | Users, permissions, categories, transactions, activity log, pivots. |
| **Seed order** | `database/seeders/DatabaseSeeder.php` | Roles → admin user → categories → transactions. |
| **Tests** | `tests/` | Pest; feature tests under `tests/Feature/` (including `Auth/`). |
| **Config** | `config/` | Standard Laravel; Spatie permission config after publish. |

When you add a feature, start from **`routes/web.php`** (or `auth.php`), then the matching **controller**, **view** under `resources/views/`, and **model** + **migration** if the schema changes.

---

## Tests

```bash
php artisan test
```

---

## License

This project uses the **MIT License** (see `composer.json`).
