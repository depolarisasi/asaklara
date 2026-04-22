# Progress — ASAK Agency Website

## Yang Sudah Berfungsi ✅

### Backend
- [x] Semua 5 public controllers (Home, About, Services, Portfolio, Contact)
- [x] Semua 6 admin controllers (Dashboard, Portfolio, Service, Team, Submission, Settings)
- [x] Semua 9 models dengan SoftDeletes, AuditLog
- [x] 11 migrations (termasuk soft deletes & audit logs)
- [x] Semua routes (public + admin + trash/restore/force-delete)
- [x] 6 seeders (Database, Portfolio, ProcessStep, Service, Setting, Team)
- [x] `database/schema.sql` untuk deploy production
- [x] Response cache terdaftar di routes (home, about, services, portfolio)

### Frontend Publik
- [x] home.blade.php — Refactor Styling: Pembersihan inline styles & optimasi Tailwind
- [x] about.blade.php — Refactor Styling: Pembersihan inline styles & optimasi Tailwind
- [x] services.blade.php — Refactor Styling: Pembersihan inline styles & optimasi Tailwind
- [x] portfolio.blade.php — Refactor Styling: Pembersihan inline styles & optimasi Tailwind
- [x] contact.blade.php — Refactor Styling: Pembersihan inline styles & optimasi Tailwind
- [x] resources/css/app.css — Konsolidasi utility classes & Custom CSS Variables sistem --pub-*
- [x] public.blade.php — Layout dengan CSS variables, light/dark theme switcher
- [x] navbar.blade.php — Pill nav, mobile menu, scroll-aware
- [x] footer.blade.php — Logo, newsletter form, links, social icons
- [x] Restorasi Hero Index — Grid 50/50, premium glassmorphism, dan unifikasi navigasi
- [x] Restorasi CTA Gradient — Perbaikan sintaks modern CSS variable untuk background & gradient kartu.

### Frontend Admin
- [x] Dashboard.vue — Stats + recent submissions + quick links
- [x] Portfolio: Index, Form (FIXED boolean), Trash
- [x] Team: Index, Form (FIXED boolean), Trash
- [x] Services: Index, Form (sudah benar), Trash
- [x] Submissions: Index, Show
- [x] Settings: Index (hero, about, stats, contact, social)
- [x] AdminLayout.vue

### Infrastructure
- [x] Storage symlink (`public/storage`) — sudah dibuat
- [x] Response cache config — sudah dipublish
- [x] Vite config (public + admin entry points)
- [x] Ziggy route generation
- [x] Logo assets (red, gold, horizontal, square, favicon semua size)

## Yang Belum Selesai / Perlu Perhatian ⚠️

### Konten
- [ ] Database masih kosong/seed data — perlu diisi dari admin sebelum go-live
- [ ] Logo di navbar: hardcoded ke `/logo/asak-horizontal-logo-red.png` di light mode — bisa konfigurasikan lewat settings jika perlu variasi

### Production Checklist
- [ ] Ganti `APP_ENV=production`, `APP_DEBUG=false` di `.env`
- [ ] Set `DB_*` credentials database production
- [ ] Run `php artisan migrate --force` di production
- [ ] Run `php artisan storage:link` di production
- [ ] Run `npm run build` lalu upload folder `public/build`
- [ ] Set `APP_URL` sesuai domain production (untuk asset URL yang benar)

### Nice-to-have (belum diimplementasi)
- [ ] Newsletter form di footer — saat ini `onsubmit="return false;"` (dummy)
- [ ] Resize/compress gambar saat upload menggunakan intervention/image (upload langsung store, belum diprocess)
- [ ] Pagination di portfolio publik jika data banyak
- [ ] SEO meta tags per halaman (saat ini hanya meta description global)

## Known Issues
- Tidak ada bug kritis. Penyesuaian mockup ke kode sudah selesai 100% untuk Hero Section.
- Navbar sudah terunifikasi menjadi satu kontainer responsif.
