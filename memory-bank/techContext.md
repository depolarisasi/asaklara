# Tech Context — ASAK Agency Website

## Stack

| Layer | Teknologi | Versi |
|---|---|---|
| Backend | Laravel | 12 |
| PHP | PHP | 8.2+ |
| Frontend Admin | Vue 3 + Inertia.js | Inertia v2 |
| Frontend Public | Blade Templates + Alpine.js | - |
| Styling | Tailwind CSS (v3 untuk public, v4 lewat @tailwindcss/vite untuk admin) | - |
| Build | Vite + laravel-vite-plugin | Vite 7 |
| State/Utils | @vueuse/core | v13 |
| Routing JS | Ziggy (tightenco/ziggy) | v2.6 |
| Image Processing | Intervention Image | v3 |
| Response Cache | spatie/laravel-responsecache | v7.7 |
| Auth | Laravel Breeze | - |
| DB | SQLite (dev) / MySQL (prod) | - |
| Testing | PHPUnit | 11 |

## Setup & Run
```bash
# Install dependencies
composer install && npm install

# Migrate + seed
php artisan migrate --seed

# Buat storage symlink (wajib untuk image upload!)
php artisan storage:link

# Development
composer run dev   # atau: php artisan serve + npm run dev

# Build production
npm run build

# Testing
php artisan test
```

## Konfigurasi Penting
- `config/responsecache.php` — response cache (lifetime: 7 hari default)
- `config/filesystems.php` — disk public untuk upload gambar
- `.env` — `APP_URL` harus benar untuk `asset('storage/...')` URL generation
- `resources/js/ziggy.js` — di-generate ulang dengan `php artisan ziggy:generate` jika ada route baru

## Vite Entry Points
- `resources/css/app.css` — public CSS
- `resources/js/app.js` — public JS (Alpine.js)
- `resources/js/admin.js` — admin JS (Vue 3 + Inertia + Ziggy)

## CSS Variables Theme
Public layout menggunakan CSS custom properties untuk theming:
- Light mode: Burgundy (`#8F1A00`) + Gold (`#FBC246`) + Warm Cream (`#FBF8F0`)
- Dark mode: Gold (`#FBC246`) + Deep Navy (`#0A1520`)
- Toggle via `html.light` class + localStorage + cookie `asak-mode`
