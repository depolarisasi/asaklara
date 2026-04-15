# System Patterns — ASAK Agency Website

## Arsitektur Umum
```
Browser → Laravel Router → Controller → Model → View/Inertia Page
                       ↓
              Response Cache (publik GET only)
```

## Pola Penting

### 1. Response Cache Strategy
- **Home, About, Services, Portfolio:** Di-cache via `CacheResponse::class` middleware
- **Contact:** `DoNotCacheResponse::class` — ada flash message & CSRF form
- **Admin:** Tidak di-cache (behind `auth` middleware)
- Clear cache: `php artisan responsecache:clear` setelah update konten admin
- Config: `config/responsecache.php`

### 2. Image Storage
- Upload disimpan ke `storage/app/public/{portfolios|team|services}/`
- Diakses via `public/storage/` symlink (buat dengan `php artisan storage:link`)
- Model accessor `getImageUrlAttribute()` — otomatis handle uploaded path vs external URL vs fallback placeholder
- Resize/compress via `intervention/image` v3 (optional, belum diimplementasi di semua controller)

### 3. Boolean FormData Bug Pattern (SOLVED)
- **Masalah:** `FormData.append('active', true)` → string `'true'` — Laravel validation `'boolean'` menolaknya
- **Solusi:** Selalu gunakan `data.append('active', form.value.active ? '1' : '0')`
- **File yang sudah fix:** Portfolio/Form.vue, Team/Form.vue
- **File yang sudah benar sejak awal:** Services/Form.vue

### 4. Admin Controller Pattern — include image_url
Semua controller yang pass model ke Inertia untuk form edit harus include `image_url` accessor secara eksplisit:
```php
// BENAR
'portfolio' => [...$portfolio->toArray(), 'image_url' => $portfolio->image_url]
// SALAH (image_url tidak ter-include karena $appends tidak di-set)
'portfolio' => $portfolio
```

### 5. Soft Deletes
Semua model utama pakai `SoftDeletes`. Flow:
- `destroy()` → soft delete → tampil di Trash
- `restore()` → kembalikan dari trash
- `forceDelete()` → hapus permanen

### 6. Settings System
- Key-value store di tabel `settings` dengan grouping
- `Setting::getGroup('hero')` → array semua key dalam group
- `Setting::set('hero.headline', 'value', 'hero')` untuk update
- Cache per group, 1 jam TTL
- Clear cache setelah update: `Cache::forget("settings.group.{$group}")`

### 7. Alpine.js Usage
- Loaded via `resources/js/app.js` di semua halaman publik
- **Contact form:** `x-data="{ sending: false }"` + `@submit="sending = true"` untuk loading state tombol
- Navbar & tema switcher menggunakan vanilla JS (bukan Alpine)

### 8. Route Naming Convention
```
home, about, services, portfolio, contact, contact.submit
admin.dashboard
admin.portfolio.{index|create|store|edit|update|destroy|trash|restore|force-delete}
admin.team.{...}
admin.services.{...}
admin.submissions.{index|show|read|destroy}
admin.settings.{index|update}
admin.process-steps.{store|update|destroy}
```
