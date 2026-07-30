# Langkah-Langkah Pembuatan Web Reservasi Hotel (Laravel 11, Livewire 3 & Midtrans)

Berikut adalah to-do list terperinci dari awal pembuatan project hingga integrasi sistem pembayaran Midtrans menggunakan **Laravel Livewire 3** untuk interaktivitas tanpa *reload* halaman.

## 1. Persiapan Awal (Setup Project & Lingkungan)
- [+] **Install Laravel 11**: 
  - Buka terminal, arahkan ke folder yang diinginkan.
  - Eksekusi: `composer create-project laravel/laravel hotel-app`
  - Masuk ke direktori: `cd hotel-app`
- [+] **Setup Storage Link**: 
  - Eksekusi: `php artisan storage:link` (untuk mengizinkan akses publik ke folder upload gambar seperti galeri dan kamar).
- [+] **Setup Database**: 
  - Buka aplikasi database (misal: phpMyAdmin atau DBeaver).
  - Buat database kosong bernama `hotel_db`.
- [+] **Konfigurasi `.env`**: 
  - Sesuaikan koneksi DB:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hotel_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```
- [+] **Install Livewire 3**: 
  - Eksekusi: `composer require livewire/livewire`
  - *(Pada Laravel 11 dan Livewire 3, script & style otomatis terinjeksi, tidak perlu manual penambahan `@livewireStyles` di layout).*

## 2. Pemodelan Database (Models, Migrations & Relasi)
Buat struktur tabel dengan menjalankan perintah `php artisan make:model NamaModel -m`. Pastikan struktur migrasinya rinci:
- [+] **Tabel `users`**:
  - Kolom tambahan: `role` (enum: 'admin', 'customer' | default: 'customer'), `phone` (string), `address` (text).
- [+] **Tabel `rooms`** (Kamar):
  - Kolom: `name` (string), `slug` (string), `description` (text), `price` (decimal), `capacity` (integer), `status` (enum: 'available', 'maintenance').
- [+] **Tabel `facilities`** (Fasilitas):
  - Kolom: `name` (string), `icon` (string - untuk class fontawesome atau path SVG), `description` (text).
- [+] **Tabel `room_facility`** (Tabel Pivot/Many-to-Many):
  - Kolom: `room_id` (foreign key), `facility_id` (foreign key).
- [+] **Tabel `galleries`** (Galeri Hotel/Kamar):
  - Kolom: `room_id` (foreign key, nullable jika foto umum), `image_path` (string), `caption` (string, nullable), `is_featured` (boolean).
- [+] **Tabel `testimonials`** (Ulasan/Testimoni Pelanggan):
  - Kolom: `user_id` (foreign key), `booking_id` (foreign key), `rating` (integer 1-5), `review` (text), `is_approved` (boolean, untuk moderasi admin).
- [+] **Tabel `bookings`** (Reservasi Utama):
  - Kolom: `booking_code` (string unik), `user_id` (foreign key), `room_id` (foreign key), `check_in` (date), `check_out` (date), `total_guests` (integer), `total_price` (decimal), `status` (enum: 'pending', 'paid', 'canceled', 'completed').
- [+] **Tabel `payments`** (Detail Pembayaran):
  - Kolom: `booking_id` (foreign key), `user_id` (foreign key), `order_id` (string unik untuk midtrans), `gross_amount` (decimal), `payment_type` (string, misal: 'bank_transfer', 'gopay'), `transaction_id` (string, nullable), `snap_token` (string, nullable), `transaction_status` (enum: 'pending', 'success', 'failed', 'refund' | default: 'pending'), `paid_at` (datetime, nullable).

*Setelah selesai, jalankan: `php artisan migrate`.*

## 3. Sistem Autentikasi (Breeze + Livewire Volt)
- [+] **Install Auth Package**: 
  - Eksekusi: `composer require laravel/breeze --dev`
  - Eksekusi: `php artisan breeze:install livewire`
  - Eksekusi: `npm install` dan `npm run build`
- [+] **Konfigurasi Middleware & Role**: 
  - Buat Middleware `IsAdmin`: `php artisan make:middleware IsAdmin`
  - Logika di `IsAdmin`: cek apakah `auth()->user()->role == 'admin'`.
  - Daftarkan middleware di `bootstrap/app.php` (pada Laravel 11).

## 4. Integrasi Frontend ke Blade & Setup Layout
Pindahkan aset HTML murni Anda agar bisa dipakai oleh Livewire.
- [+] **Pembuatan Layout Utama**: 
  - Gunakan `resources/views/layouts/app.blade.php`.
  - Buat komponen layout tambahan: `resources/views/livewire/layout/navigation.blade.php` (header) dan `footer.blade.php`.
- [+] **Penyusunan Asset Publik**: 
  - Pindahkan semua CSS, JS pendukung, dan gambar statis ke direktori `public/assets/`.
- [+] **Ubah Elemen UI ke Blade Component/Livewire**: 
  - Jadikan *Card Kamar* sebagai komponen Livewire terpisah agar interaktif saat ditambah ke keranjang.

## 5. Pembuatan Fitur Inti dengan Livewire (CRUD & Bisnis Logik)
Gunakan command `php artisan make:livewire NamaKomponen`.
- [ ] **Admin Panel (Livewire Components)**:
  + `Admin\RoomManager`: Menampilkan datatable Livewire untuk CRUD kamar (upload foto kamar langsung tersimpan ke Storage).
  + `Admin\FacilityManager`: CRUD fasilitas.
  + `Admin\GalleryManager`: Upload multi-foto ke tabel `galleries`.
  - `Admin\BookingList`: Tabel real-time melihat daftar pemesanan masu`k.
  - `Admin\TestimonialModeration`: Menyetujui (`is_approved = true`) testimoni dari user agar tampil di halaman depan.
- [ ] **Customer Area (Livewire Components)**:
  - `Home\LandingPage`: Menampilkan kamar unggulan, galeri (Carousel), dan daftar testimoni yang sudah disetujui.
  - `Room\SearchFilter`: Menampilkan input kalender check-in/check-out. Memiliki fungsi `$watch` yang langsung memfilter kamar tersedia dari database secara *real-time*.
  - `Room\Detail`: Menampilkan detail kamar, list fasilitas (dari relasi pivot), galeri khusus kamar tersebut. 
  - `Booking\CheckoutForm`:
    - Validasi tanggal dan jumlah tamu.
    - Kalkulasi harga *real-time* (Harga Kamar x Jumlah Malam).
    - Insert data ke tabel `bookings` dan tabel `payments`.

## 6. Integrasi Midtrans (Sistem Pembayaran) dengan Livewire
- [ ] **Persiapan Midtrans**: 
  - Login Dashboard Midtrans -> Settings -> Access Keys (Dapatkan Merchant ID, Server Key, Client Key Sandbox).
- [ ] **Install & Konfigurasi Package**: 
  - `composer require midtrans/midtrans-php`
  - Masukkan Key di `.env` (seperti yang dicontohkan di tahap sebelumnya).
- [ ] **Logika Checkout di Livewire (`Booking\CheckoutForm`)**:
  - Di fungsi `pay()` dalam Livewire, setelah data `booking` dan `payment` dibuat:
    ```php
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$isProduction = false;
    
    $params = [
        'transaction_details' => [
            'order_id' => $payment->order_id,
            'gross_amount' => $booking->total_price,
        ],
        'customer_details' => [
            'first_name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]
    ];
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    $payment->update(['snap_token' => $snapToken]);
    
    // Kirim token ke frontend (Javascript)
    $this->dispatch('pay-with-snap', token: $snapToken);
    ```
- [ ] **Implementasi Script Snap di View Checkout**:
  - Masukkan `<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>`.
  - Tangkap event Livewire via JS:
    ```javascript
    document.addEventListener('pay-with-snap', function(event) {
        window.snap.pay(event.detail.token, {
            onSuccess: function(result){ /* Redirect ke halaman sukses */ },
            onPending: function(result){ /* Redirect ke halaman menunggu */ },
            onError: function(result){ /* Tampilkan error */ }
        });
    });
    ```

## 7. Penanganan Webhook / Notifikasi Otomatis Midtrans
- [ ] **Setup Route & Middleware**: 
  - Buat route `POST /api/midtrans-callback` di `routes/api.php`.
- [ ] **Buat `MidtransController@callback`**:
  - Ambil payload dari Midtrans (JSON).
  - Buat verifikasi Signature Key: `hash("sha512", order_id + status_code + gross_amount + server_key)`. Bandingkan dengan signature dari request.
  - Jika valid, cek `transaction_status`:
    - Jika `settlement` / `capture`: update `bookings.status = 'paid'`, `payments.transaction_status = 'settlement'`.
    - Jika `expire` / `cancel`: update status menjadi `canceled`.
- [ ] **Tautkan URL di Dashboard Midtrans**: 
  - Masukkan endpoint API tersebut ke menu *Payment Notification URL* di Midtrans. (Gunakan Ngrok jika masih di *localhost*).

## 8. Testing, Evaluasi & Deployment
- [ ] **Test Alur Reservasi (Sandbox)**: 
  - Login sebagai Customer.
  - Filter kamar -> Isi form -> Munculkan pop-up Midtrans -> Bayar dengan [Kartu Kredit Dummy / VA Dummy](https://docs.midtrans.com/docs/testing-payments).
  - Pastikan database terupdate dan Webhook berhasil berjalan.
- [ ] **Test Admin Panel**: 
  - Login sebagai Admin -> Cek apakah pemesanan masuk. -> Approve Testimoni.
- [ ] **Optimasi & Deploy (Production)**: 
  - Ubah `.env` (`APP_ENV=production`, `APP_DEBUG=false`).
  - Ganti *Server/Client Key Midtrans* dengan versi Production.
  - Eksekusi `php artisan optimize` dan `npm run build`.
