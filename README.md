# Sitio-Tio

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white" alt="PHP 8.2 atau lebih baru">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Livewire-4-FB70A9?logo=livewire&logoColor=white" alt="Livewire 4">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS 3">
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white" alt="MySQL 8">
  <img src="https://img.shields.io/badge/Vite-5-646CFF?logo=vite&logoColor=white" alt="Vite 5">
  <img src="https://img.shields.io/badge/Midtrans-Payment-002B80" alt="Midtrans Payment">
</p>



## About Project

Aplikasi reservasi hotel berbasis web. Pengunjung dapat melihat kamar, membuat pemesanan, dan menyelesaikan pembayaran melalui Midtrans. Administrator dapat mengelola kamar, unit kamar, fasilitas, galeri, promo, reservasi, transaksi, dan data tamu.

Aplikasi ini menyediakan alur pemesanan dari pencarian kamar sampai pembayaran dan status pembayaran. Reservasi yang belum dibayar akan dibatalkan otomatis setelah melewati batas waktu yang ditentukan. Area admin dilindungi oleh autentikasi, verifikasi email, dan middleware peran admin.

## Tech Stack

| Area | Teknologi |
| --- | --- |
| Backend | PHP 8.2+, Laravel 11 |
| UI reaktif | Livewire 4, Livewire Volt |
| Template | Blade |
| Styling | Tailwind CSS 3, `@tailwindcss/forms`, PostCSS, Autoprefixer |
| Frontend build | Vite 5, Laravel Vite Plugin |
| Interaksi frontend | Alpine.js, Alpine Clipboard, Axios, SweetAlert2 |
| Visualisasi data | Chart.js |
| Database | MySQL |
| Pembayaran | Midtrans PHP SDK |
| Dokumen dan ekspor | Laravel DOMPDF, Laravel Excel |
| Autentikasi | Laravel Breeze |
| Pengujian | Pest 3, PHPUnit |

## Requirements

- PHP 8.2 atau lebih baru dengan ekstensi `pdo_mysql`.
- Composer 2.
- Node.js dan npm.
- MySQL 8 atau database MySQL-compatible.
- Akun Midtrans Sandbox atau Production bila fitur pembayaran akan digunakan.

## Installation Guide

1. Clone repositori dan masuk ke direktori proyek.

   ```bash
   git clone <repository-url>
   cd sitio-tio
   ```

2. Instal dependensi PHP dan JavaScript.

   ```bash
   composer install
   npm ci
   ```

3. Salin konfigurasi lingkungan, lalu isi koneksi MySQL dan kredensial Midtrans.

   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

   Pada macOS atau Linux, gunakan `cp .env.example .env`.

4. Buat database MySQL, lalu atur variabel `DB_*` pada `.env`.

   ```sql
   CREATE DATABASE sitio_tio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

5. Jalankan migrasi dan data awal.

   ```bash
   php artisan migrate --seed
   ```

6. Buat symbolic link untuk file unggahan publik.

   ```bash
   php artisan storage:link
   ```

7. Jalankan server aplikasi dan Vite pada terminal terpisah.

   ```bash
   php artisan serve
   npm run dev
   ```

   Aplikasi tersedia di URL yang ditampilkan oleh `php artisan serve`.

8. Untuk membatalkan reservasi pending secara otomatis, jalankan scheduler pada lingkungan lokal atau daftarkan cron di server.

   ```bash
   php artisan schedule:work
   ```

   Produksi dapat menjalankan `php artisan schedule:run` setiap menit. Scheduler memanggil `bookings:expire-pending` setiap menit.

## Project Structure

```text
app/
  Console/Commands/       Perintah Artisan, termasuk kedaluwarsa reservasi
  Exports/                Ekspor data transaksi
  Http/Controllers/       Callback Midtrans dan controller HTTP
  Http/Middleware/        Middleware otorisasi admin
  Livewire/               Komponen halaman pelanggan dan admin
  Models/                 Model Eloquent
  View/Components/        Komponen Blade berbasis class
bootstrap/
  app.php                 Alias middleware dan pengecualian CSRF Midtrans
config/                   Konfigurasi Laravel, booking, dan Midtrans
database/
  migrations/             Skema database
  seeders/                Data awal aplikasi
public/                   Entry point dan aset publik
resources/
  css/                    CSS sumber
  js/                     Entry point Livewire dan interaksi frontend
  views/                  Layout, komponen Blade, dan view Livewire
routes/
  web.php                 Rute HTTP utama
  console.php             Jadwal perintah Artisan
```

## Environment Variables

Salin `.env.example` menjadi `.env`. Jangan commit file `.env` atau kredensial pembayaran.

| Variabel | Keterangan |
| --- | --- |
| `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_DEBUG`, `APP_URL` | Identitas dan mode aplikasi Laravel |
| `APP_LOCALE`, `APP_FALLBACK_LOCALE`, `APP_TIMEZONE` | Bahasa dan zona waktu aplikasi |
| `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Koneksi database utama |
| `SESSION_DRIVER`, `CACHE_STORE`, `QUEUE_CONNECTION` | Driver sesi, cache, dan antrean. Template menggunakan database untuk ketiganya. |
| `FILESYSTEM_DISK` | Disk penyimpanan Laravel untuk unggahan |
| `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` | Konfigurasi email |
| `MIDTRANS_CLIENT_KEY`, `MIDTRANS_SERVER_KEY` | Kredensial API Midtrans |
| `MIDTRANS_IS_PRODUCTION` | Gunakan `false` untuk Sandbox dan `true` untuk Production |
| `MIDTRANS_IS_SANITIZED`, `MIDTRANS_IS_3DS` | Pengaturan sanitasi dan 3DS Midtrans |
| `BOOKING_HOLD_MINUTES` | Durasi reservasi berstatus pending sebelum dibatalkan. Default: `30`. |
| `VITE_APP_NAME` | Nama aplikasi yang tersedia untuk bundle Vite |

Endpoint callback pembayaran adalah `POST /midtrans/callback`. Endpoint ini dikecualikan dari validasi CSRF agar notifikasi Midtrans dapat diterima.

### Testing Environment

Pengujian hanya boleh memakai database MySQL terpisah bernama `sitio_tio_testing`. Salin `.env.testing.example` menjadi `.env.testing`, lalu buat database dan pengguna khusus berikut.

```sql
CREATE DATABASE sitio_tio_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'sitio_tio_test'@'127.0.0.1' IDENTIFIED BY 'change-this-test-password';
GRANT ALL PRIVILEGES ON sitio_tio_testing.* TO 'sitio_tio_test'@'127.0.0.1';
FLUSH PRIVILEGES;
```

`Tests\TestCase` akan menghentikan test bila koneksi bukan MySQL atau database tidak sama dengan `TEST_DB_DATABASE` di `phpunit.xml`.

## Useful Commands

| Perintah | Fungsi |
| --- | --- |
| `php artisan serve` | Menjalankan server pengembangan Laravel |
| `npm run dev` | Menjalankan Vite development server dengan HMR |
| `npm run build` | Membuat bundle frontend produksi |
| `php artisan migrate --seed` | Menjalankan migrasi dan data awal |
| `php artisan migrate:fresh --seed` | Menghapus seluruh tabel, lalu membuat ulang skema dan data awal |
| `php artisan storage:link` | Membuat link storage publik untuk unggahan |
| `php artisan test` | Menjalankan seluruh test |
| `php artisan test tests/Feature/Livewire/RoomsAdminTest.php` | Menjalankan satu file test |
| `php artisan test --filter="stores a room"` | Menjalankan test berdasarkan nama |
| `php artisan bookings:expire-pending` | Membatalkan reservasi pending yang sudah melewati tenggat |
| `php artisan schedule:work` | Menjalankan scheduler secara terus-menerus |
| `php artisan optimize:clear` | Membersihkan cache konfigurasi, rute, view, dan aplikasi |
| `php artisan route:list` | Menampilkan seluruh rute terdaftar |

## Troubleshooting

### `Base table or view not found`

Pastikan konfigurasi database pada `.env` benar, lalu jalankan `php artisan migrate --seed`. Karena sesi, cache, dan antrean pada template memakai driver database, migrasi wajib dijalankan sebelum aplikasi digunakan.

### Gambar unggahan tidak tampil

Jalankan `php artisan storage:link`. Pastikan `FILESYSTEM_DISK` dan izin direktori `storage` sudah benar.

### Pembayaran Midtrans tidak berjalan

Periksa `MIDTRANS_CLIENT_KEY`, `MIDTRANS_SERVER_KEY`, dan `MIDTRANS_IS_PRODUCTION`. Untuk webhook, URL publik harus dapat dijangkau Midtrans dan diarahkan ke `/midtrans/callback`.

### Perubahan Tailwind atau JavaScript tidak terlihat

Jalankan `npm run dev` saat pengembangan. Untuk build produksi, jalankan `npm run build`, kemudian bersihkan cache Laravel dengan `php artisan optimize:clear` bila diperlukan.

### Test gagal sebelum dijalankan

Buat `.env.testing` dari `.env.testing.example` dan pastikan database `sitio_tio_testing` tersedia. Test sengaja menolak koneksi selain MySQL dan database pengembangan agar data lokal tidak terhapus oleh `RefreshDatabase`.

### Reservasi pending tidak berubah menjadi dibatalkan

Jalankan `php artisan bookings:expire-pending` untuk memeriksa proses secara manual. Agar otomatis, jalankan `php artisan schedule:work` secara lokal atau konfigurasi cron produksi setiap menit.
