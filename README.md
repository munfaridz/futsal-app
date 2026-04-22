<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

# Studi Kasus: Sistem Booking Lapangan Futsal


---

## 👤 Identitas Mahasiswa
- **Nama:** Munfarid Zulkahfi
- **NIM:** 220101016
- **Program Studi:** Sistem Informasi

---

## 📝 Penjelasan Tema Kasus
Proyek ini adalah **Sistem Manajemen Booking Lapangan Futsal** berbasis web. pengelolaan operasional pada fasilitas olahraga (GOR Futsal). Secara arsitektur, sistem ini menyelesaikan tiga masalah utama: Autentikasi Keamanan, Manajemen Data (CRUD), dan Integritas Jadwal.

### Fitur Utama:
1. **Sistem Autentikasi:**
   - Login menggunakan pengamanan **Session**.
   - Password pengguna wajib dienkripsi menggunakan algoritma **Bcrypt** (Laravel Hashing).
2. **Arsitektur Database:**
   - Terdiri dari 2 tabel utama: `users` (untuk kredensial) dan `bookings` (tabel bisnis).
   - Relasi antar tabel menggunakan *Foreign Key* `user_id`.
3. **Implementasi CRUD:**
   - Pengguna dapat **Menampilkan** jadwal dalam bentuk Card/Grid yang modern.
   - Pengguna dapat **Menambah** jadwal baru dengan validasi jam otomatis.
   - Pengguna dapat **Mengubah** dan **Menghapus** data booking yang sudah ada.
4. **Keamanan Data:**
   - Halaman manajemen (CRUD) hanya bisa diakses oleh pengguna yang sudah terautentikasi (berhasil login).
   - Dilengkapi fungsi `getEloquentQuery` untuk memastikan keamanan data antar pengguna.

---

## 🛠️ UI & Framework
- **Bahasa Pemrograman:** PHP 8.2+
- **Framework:** Laravel 12 & Filament PHP v3
- **Database:** MySQL
- **Frontend UI:** Tailwind CSS (via Filament)

---
### Cara Menjalankan
1. Clone repositori ini.
2. Jalankan `composer install`.
3. Copy `.env.example` ke `.env` dan atur koneksi database.
4. Jalankan `php artisan migrate`.
5. Jalankan `php artisan serve`.