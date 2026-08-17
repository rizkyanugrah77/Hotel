# Sitio Tio

## Stack and entrypoints

- This is a Laravel 11 (PHP 8.2) hotel-reservation application using Livewire 4, Volt, Tailwind 3, and Vite 5.
- `routes/web.php` is the HTTP entrypoint. Customer and admin pages are primarily Livewire components in `app/Livewire/`; their Blade views live under `resources/views/livewire/`. Conventional controllers remain for the Midtrans callback and several admin routes.
- Admin routes require `auth`, `isAdmin`, and verified email. The `isAdmin` alias is registered in `bootstrap/app.php`.
- Active frontend sources are the root `resources/`, `package.json`, and `vite.config.js`. Root Vite builds `resources/css/app.css`, `resources/js/app.js`, and `resources/js/main.js`; `public/dist/` is a separately tracked static bundle and is not produced by the root build.

## Local workflow

- Install dependencies with `composer install` and `npm ci`. Configure database credentials in `.env` before migrations; the environment template leaves them blank and defaults session, cache, and queue drivers to database-backed stores.
- Use `php artisan migrate --seed` to create the development schema and sample data. Run `php artisan storage:link` when working with room or gallery uploads; Livewire stores them on the `public` disk under `assets/img/rooms` and `assets/img/gallery`.
- Run the app with `php artisan serve` and frontend HMR with `npm run dev`. Use `npm run build` for frontend verification.
- There is no configured lint or typecheck command. Run PHP tests with `php artisan test`; target a file with `php artisan test tests/Feature/Livewire/RoomsAdminTest.php` or a case with `php artisan test --filter="stores a room"`.
- Feature tests globally use `RefreshDatabase`, but `phpunit.xml` does not set a SQLite test connection. Configure a disposable test database before running the suite; do not assume in-memory SQLite.

## Frontend and Livewire

- Layouts load all three Vite entrypoints. `resources/js/app.js` starts Livewire manually; `resources/js/main.js` re-initializes DOM behavior on `livewire:navigated`. Keep this lifecycle in mind when adding browser interactions to `wire:navigate` pages.
- Tailwind scans Blade templates only (`resources/views/**/*.blade.php`), not JavaScript. Classes used solely in JS must be made visible to Tailwind (for example, via a scanned template or a Tailwind safelist) or production builds will omit them.

## Payments

- Midtrans credentials and mode are configured only through `config/midtrans.php` and the `MIDTRANS_*` environment variables.
- The live callback is `POST /midtrans/callback` in `routes/web.php`, handled by `MidtransController::callback`; `bootstrap/app.php` exempts `midtrans/*` from CSRF validation. Do not follow the stale `routes/api.php` callback path described in `implementation_plan.md` without updating these connected pieces.
