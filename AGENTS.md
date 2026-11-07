# AGENTS.md — LSP Proyek Asesor

## Project

Laravel 9.2 (PHP 8.1+) — Lembaga Sertifikasi Profesi management system.
Database: MySQL (`lsp`), root/no password. Auth: Laravel UI + Sanctum.
RBAC: Spatie Permission (`admin`, `asesi`, `asesor`).

## Roles & Route Prefixes

| Role   | Prefix              | Middleware                        |
|--------|---------------------|-----------------------------------|
| admin  | `/admin`            | `role:admin, throttle:admin, honeypot` |
| asesor | `/dashboard-asesor` | `role:asesor, throttle:asesor`    |
| asesi  | `/dashasesi`        | `auth, role:asesi, throttle:asesi, honeypot` |

- Asesor login at `/loginasesor` (`AsesorAuthController`).
- Asesor route names: `dashboard.asesor.*`.

## Honeypot Middleware (`app/Http/Middleware/Honeypot.php`)

Runs on **all POST/PUT/PATCH under admin and asesi**. Forms must include hidden fields `_hp` (empty) and `_hpt` (Unix timestamp) or requests are silently swallowed.

## Developer Commands

```sh
php artisan serve
npm run dev
phpunit                                    # in-memory SQLite per phpunit.xml
phpunit tests/Feature/GaleriFotoTest.php
php artisan db:seed
php artisan migrate:fresh --seed
```

## Quirks

- `phpunit.xml` uses in-memory SQLite (`:memory:`).
- `app/Helpers/MapsHelper.php` is not auto-loaded via composer; include manually if needed.

