---
description: Repository Information Overview
alwaysApply: true
---

# Management Hotel Dieng Information

## Summary
A Laravel-based web application for hotel management, utilizing modern PHP framework with frontend assets built via Vite.

## Structure
- **app/**: Core application logic including Models, Controllers, Services, and Providers
  - **app/Services/**: Business logic services including CollabService and UserService for user and collaboration management
- **bootstrap/**: Application bootstrap files and cache
- **config/**: Configuration files for various Laravel components (app, database, mail, etc.)
- **database/**: Migrations, seeders, and factories for database management
- **public/**: Web-accessible files including assets, favicon, and entry point index.php
- **resources/**: Frontend resources including CSS, JS, SASS, and Blade views
- **routes/**: Route definitions for web, admin, console, and developer access
- **storage/**: Application storage for logs, cache, and uploaded files
- **tests/**: PHPUnit test suites for Unit and Feature tests

## Language & Runtime
**Language**: PHP, JavaScript
**Version**: PHP ^8.2, Laravel ^12.0
**Build System**: Composer (PHP), Vite (JavaScript)
**Package Manager**: Composer, npm

## Dependencies
**Main Dependencies** (PHP):
- laravel/framework: ^12.0
- laravel/tinker: ^2.10.1
- laravel/ui: ^4.6
- spatie/laravel-permission: ^6.20

**Development Dependencies** (PHP):
- barryvdh/laravel-debugbar: ^3.16
- fakerphp/faker: ^1.23
- laravel/pail: ^1.2.2
- laravel/pint: ^1.13
- laravel/sail: ^1.41
- mockery/mockery: ^1.6
- nunomaduro/collision: ^8.6
- phpunit/phpunit: ^11.5.3

**Frontend Dependencies** (production):
- @alpinejs/persist: ^3.14.1
- @fullcalendar/core: ^6.1.15
- @fullcalendar/daygrid: ^6.1.15
- @fullcalendar/interaction: ^6.1.15
- @fullcalendar/list: ^6.1.15
- @fullcalendar/timegrid: ^6.1.15
- alpinejs: ^3.14.1
- apexcharts: ^3.51.0
- chart.js: ^4.4.6
- datatables.net-dt: ^2.3.2
- dropzone: ^6.0.0-beta.2
- flatpickr: ^4.6.13
- flowbite: ^3.1.2
- fullcalendar: ^6.1.15
- jsvectormap: ^1.6.0
- simple-datatables: ^10.0.0
- sweetalert2: ^11.6.13
- swiper: ^11.1.14

**Frontend Dependencies** (dev):
- @popperjs/core: ^2.11.6
- @tailwindcss/vite: ^4.1.11
- axios: ^1.8.2
- bootstrap: ^5.2.3
- concurrently: ^9.0.1
- laravel-vite-plugin: ^1.2.0
- sass: ^1.56.1
- tailwindcss: ^4.1.11
- vite: ^6.2.4

## Build & Installation
```bash
composer install
npm install
npm run build
```

## Running the Application
For development with hot reload and queue processing:
```bash
composer run dev
```
This command runs the Laravel server, queue listener, and Vite dev server concurrently.

## Main Files & Resources
**Entry Point**: public/index.php
**Artisan CLI**: artisan
**Configuration**: config/*.php
**Routes**: routes/*.php (web, admin, api)
**API Endpoints**: routes/api.php including product user management
**Views**: resources/views/
**Assets**: resources/css/, resources/js/, resources/sass/

## Testing
**Framework**: PHPUnit
**Test Location**: tests/Unit/, tests/Feature/
**Naming Convention**: *Test.php
**Configuration**: phpunit.xml
**Run Command**:
```bash
./vendor/bin/phpunit
# or
php artisan test
```