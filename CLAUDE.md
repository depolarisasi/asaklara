> **ALWAYS READ `clauderules.md` BEFORE DOING ANYTHING IN THIS REPOSITORY.**
> This is mandatory for every task, every workflow, every session — no exceptions.

---

# CLAUDE.md — ASAK Agency Profile Website

## Tentang Proyek

**ASAK Agency** (juga dikenal sebagai *asak digital*) adalah website company profile untuk sebuah creative digital agency. Tagline utamanya: **"The Anti-Chaos Agency"** — *Done Right. Done On Time.*

Nama "Asak" berasal dari kata yang berarti **matang, siap, selesai** — merepresentasikan standar kerja agensi ini: *fully tested, fully optimized, ready for market impact.*

Website ini memiliki dua bagian utama: **halaman publik** (company profile) dan **panel admin** untuk mengelola konten secara dinamis.

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel 12 (PHP 8.2+) |
| Frontend (Admin) | Vue 3 + Inertia.js v2 |
| Frontend (Public) | Blade Templates |
| Styling | Tailwind CSS v3 + v4 (Vite) |
| Build Tool | Vite 7 + laravel-vite-plugin |
| State/Utils | @vueuse/core |
| Routing (JS) | Ziggy (tightenco/ziggy) |
| Image Processing | Intervention Image v3 |
| Response Cache | spatie/laravel-responsecache |
| Auth Scaffolding | Laravel Breeze |
| Package Manager | npm |
| Database | SQLite (dev) / MySQL (prod) |
| Testing | PHPUnit 11 |

---

## Struktur Direktori

```
app/
├── Http/
│   └── Controllers/
│       ├── HomeController.php
│       ├── AboutController.php
│       ├── ServicesController.php
│       ├── PortfolioController.php
│       ├── ContactController.php
│       └── Admin/
│           ├── DashboardController.php
│           ├── PortfolioController.php
│           ├── ServiceController.php
│           ├── TeamController.php
│           ├── ContactSubmissionController.php
│           └── SettingsController.php
└── Models/
    ├── User.php
    ├── Portfolio.php
    ├── Service.php
    ├── ServiceFeature.php
    ├── ProcessStep.php
    ├── TeamMember.php
    ├── ContactSubmission.php
    ├── Setting.php
    └── AuditLog.php

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php       → Layout utama (authenticated)
│   │   ├── guest.blade.php     → Layout guest/auth
│   │   ├── public.blade.php    → Layout halaman publik
│   │   └── navigation.blade.php
│   ├── pages/
│   │   ├── home.blade.php
│   │   ├── about.blade.php
│   │   ├── services.blade.php
│   │   ├── portfolio.blade.php
│   │   └── contact.blade.php
│   ├── components/             → Blade components
│   └── dashboard.blade.php
└── js/
    ├── app.js                  → Entry point Vue/Inertia
    ├── admin.js                → Entry point admin
    ├── bootstrap.js
    ├── ziggy.js
    ├── Pages/
    │   └── Admin/
    │       ├── Dashboard.vue
    │       ├── Portfolio/
    │       ├── Services/
    │       ├── Team/
    │       ├── Submissions/
    │       └── Settings/
    └── Layouts/
        └── AdminLayout.vue
```

---

## Routes

```
GET  /                    → HomeController@index
GET  /about               → AboutController@index
GET  /services            → ServicesController@index
GET  /portfolio           → PortfolioController@index
GET  /contact             → ContactController@index
POST /contact             → ContactController@submit  (throttle: 5/menit)

# Admin (middleware: auth)
GET    /admin             → Admin\DashboardController@index
CRUD   /admin/portfolio   → Admin\PortfolioController (+ trash/restore/force-delete)
CRUD   /admin/team        → Admin\TeamController (+ trash/restore/force-delete)
CRUD   /admin/services    → Admin\ServiceController (+ trash/restore/force-delete)
CRUD   /admin/process-steps
GET    /admin/submissions → Admin\ContactSubmissionController@index
GET/PATCH/DELETE /admin/submissions/{id}
GET/POST /admin/settings  → Admin\SettingsController
```

---

## Database (Migrasi Utama)

| Tabel | Deskripsi |
|---|---|
| `users` | Auth admin |
| `settings` | Konfigurasi global website |
| `team_members` | Data anggota tim |
| `services` | Layanan agensi |
| `service_features` | Fitur tiap layanan |
| `process_steps` | Langkah-langkah proses layanan |
| `portfolios` | Portofolio/proyek |
| `contact_submissions` | Pesan masuk dari form kontak |
| `audit_logs` | Log aktivitas admin |

Semua tabel utama mendukung **soft deletes**.

---

## Layanan ASAK Agency

1. **Brand Engineering** — Identity, UI/UX, Visual System, Graphic & Video
2. **Tech Development** — Web, Apps, Custom Software
3. **Growth Hacking** — Data-Driven Marketing & SEO
4. **Photo & Videography** — Professional visual content

---

## Nilai & Filosofi Agensi

- **Radical Transparency** — Semua proses terlacak, nol kejutan
- **Zero-Delay Protocol** — Selalu on-time, on-budget
- **Global Standard** — Pengalaman dari ratusan proyek internasional
- **Definition of Done** — Dikirim matang: tested, optimized, market-ready

---

## Cara Menjalankan

```bash
# Setup awal (install dependencies + migrate)
composer run setup

# Development (jalankan semua sekaligus: server, queue, logs, vite)
composer run dev

# Atau manual:
php artisan serve        # Laravel dev server → http://localhost:8000
npm run dev              # Vite HMR

# Build production
npm run build

# Testing
composer run test
# atau: php artisan test
```

---

## Konvensi Penting

- **Backend:** Controller tipis, logika di Model atau Service class
- **Admin UI:** Vue 3 SFC via Inertia.js — gunakan `useForm()` dari `@inertiajs/vue3`
- **Public UI:** Blade templates murni (tidak pakai Vue)
- **Routing JS:** Gunakan helper `route()` dari Ziggy untuk generate URL di Vue
- **Image upload:** Gunakan `intervention/image` untuk resize/compress sebelum simpan
- **Cache:** Response cache aktif via `spatie/laravel-responsecache` — jalankan `php artisan responsecache:clear` setelah update konten
- **Soft Delete:** Semua model utama pakai `SoftDeletes` — jangan hard delete langsung dari UI

---

## Aturan Wajib (dari clauderules.md)

- Selalu jawab dalam **Bahasa Indonesia**
- Selalu sapa user sebagai **"Big Pappa"**
- **JANGAN COMMIT KE GIT**
- Baca semua file memory bank sebelum mulai task
- Prioritaskan solusi sederhana, jangan over-engineer
- Fokus pada task yang diminta, jangan scope creep
