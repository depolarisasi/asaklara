# Deploy Guide — ASAK Agency CMS (Shared Hosting)

## Struktur yang Perlu Diupload

Upload **seluruh isi folder `laravel-version/`** ke server, tetapi **document root** harus diarahkan ke subfolder `public/`.

### Cara Upload ke cPanel (Jagoanhosting)

1. Compress folder `laravel-version/` menjadi `.zip`
2. Upload via **File Manager** cPanel ke `/home/asakdigi/`
3. Extract di sana → hasilnya `/home/asakdigi/laravel-version/`
4. Di cPanel → **Subdomains** atau **Addon Domains**, set document root ke:
   ```
   /home/asakdigi/laravel-version/public
   ```

---

## Step 1: Import Database via phpMyAdmin

1. Login ke cPanel → **phpMyAdmin**
2. Pilih database `asakdigi_comproweb`
3. Klik tab **Import**
4. Upload file `database/schema.sql`
5. Klik **Go**

> File ini sudah include semua tabel + data default (settings, team, portfolio, dll)

---

## Step 2: Konfigurasi .env

Edit file `.env` di server (via File Manager cPanel):

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_HOST=localhost          ← PENTING: ganti ke localhost di server!
DB_DATABASE=asakdigi_comproweb
DB_USERNAME=asakdigi_comproweb
DB_PASSWORD=t1#3OKfE#Me83g
```

> **PENTING:** Di shared hosting, `DB_HOST` harus `localhost` (bukan `lucky.jagoanhosting.id`)

---

## Step 3: Set File Permissions (via SSH atau File Manager)

```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

---

## Step 4: Create Storage Symlink

Via SSH (atau PHP script sekali jalan):

```bash
php artisan storage:link
```

Atau buat manual: symlink `public/storage` → `storage/app/public`

---

## Step 5: Optimize untuk Production

Via SSH:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Login Admin

Setelah deploy:

- **URL:** `https://yourdomain.com/login`
- **Email:** `admin@asak.agency`
- **Password:** `asak2024!`

> **Segera ganti password** setelah login pertama via profil atau tinker.

---

## Struktur URL

| URL | Halaman |
|-----|---------|
| `/` | Homepage |
| `/about` | About |
| `/services` | Services |
| `/portfolio` | Portfolio |
| `/contact` | Contact |
| `/login` | Admin Login |
| `/admin` | Admin Dashboard |
| `/admin/portfolio` | Kelola Portfolio |
| `/admin/team` | Kelola Tim |
| `/admin/services` | Kelola Layanan |
| `/admin/submissions` | Pesan Kontak |
| `/admin/settings` | Pengaturan Website |

---

## Upload Gambar

Gambar yang diupload via admin panel tersimpan di `storage/app/public/`.
Pastikan sudah buat symlink `public/storage` → `storage/app/public`.

---

## Troubleshooting

**500 Error:** Cek `storage/logs/laravel.log`

**Blank page:** Set `APP_DEBUG=true` sementara untuk lihat error

**Images not showing:** Jalankan `php artisan storage:link`

**Cache issue:** Hapus isi folder `bootstrap/cache/` dan `storage/framework/cache/`
