# Product Context — ASAK Agency Website

## Mengapa Proyek Ini Ada
ASAK Agency membutuhkan website company profile yang mencerminkan brand mereka sendiri: anti-chaos, transparan, dan terbukti matang. Website ini adalah "bukti pertama" kualitas kerja mereka kepada calon klien.

## Masalah yang Dipecahkan
- Calon klien tidak bisa melihat portofolio dan layanan secara terpadu
- Tidak ada saluran resmi untuk menerima inquiry/kontak
- Tim tidak bisa mengupdate konten tanpa developer (kebutuhan CMS)

## Cara Kerja
1. **Calon klien** mengunjungi website → melihat layanan, portofolio, tim → mengisi form kontak
2. **Admin** login ke `/admin` → mengelola konten (portfolio, team, services, settings) → konten ter-update di halaman publik secara real-time
3. **Response cache** menjaga performa website publik — cache dibersihkan setelah admin update konten dengan `php artisan responsecache:clear`

## Target User
- **Pengunjung publik:** Calon klien, mitra bisnis, media
- **Admin:** Tim internal ASAK Agency yang mengelola konten

## UX Goals
- Halaman publik: Fast, premium, dark/light mode, mobile-first
- Panel admin: Fungsional, sederhana, no-frills (dark theme)
- Theme switcher: Cookie-based + localStorage, persisten antar session
