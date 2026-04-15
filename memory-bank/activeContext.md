# Active Context — ASAK Agency Website

## Status Session: 2026-04-15

## Pekerjaan yang Baru Diselesaikan

### Bug Fixes (CRUD Admin)
1. **Portfolio/Form.vue** — Fix boolean `active`/`featured` dikirim sebagai `'true'`/`'false'` string lewat FormData. Fix: gunakan `? '1' : '0'`
2. **Team/Form.vue** — Fix yang sama untuk `active`
3. **Admin/PortfolioController.php** `edit()` — Fix: include `image_url` accessor dalam response (konsisten dengan Team & Service controller)
4. **Portfolio/Form.vue** — Fix image preview menggunakan `portfolio?.image_url` bukan `portfolio?.image`

### Infrastructure
5. **`php artisan storage:link`** — Sudah dijalankan, symlink `public/storage` sudah ada
6. **Response Cache** — Config dipublish ke `config/responsecache.php`, middleware didaftarkan di `routes/web.php`
7. **Routes** — Home, About, Services, Portfolio di-cache; Contact menggunakan `DoNotCacheResponse`

### Enrichment Halaman Publik
8. **services.blade.php** — Diperkaya dengan: stats bar (150+/50+/5+/100%), service nav tabs di hero, "Why ASAK" differentiators section, floating number badge per service
9. **portfolio.blade.php** — Diperkaya dengan: stats bar (dynamic count), improved empty state, featured badge di kartu, image scale on hover, CTA link di featured card pertama, layout hero card diperbesar (16/7 ratio)

### Alpine.js
10. **contact.blade.php** — Alpine.js `x-data="{ sending: false }"` + `@submit="sending = true"` — loading state pada tombol "Send Message", field focus border highlight

## Next Steps yang Disarankan
- Test upload gambar di portfolio/team/services dari admin panel
- Jalankan `php artisan responsecache:clear` setelah setiap batch update konten
- Isi database: tambah portfolio, services, team lewat admin sebelum go-live
- Ganti logo-merah di navbar light mode dengan versi yang sesuai branding
- Deploy ke production: ikuti panduan di `DEPLOY.md`
