# Aplikasi Shortlink & Analytics

Aplikasi berbasis web (Laravel) untuk membuat tautan pendek (shortlink), mengelola slug kustom, menghasilkan QR Code, dan memantau analitik klik secara real-time.

## 📌 Fitur Utama

- **Manajemen Shortlink**:
  - Membuat tautan pendek dengan slug otomatis atau kustom.
  - Mendukung judul tautan untuk pengorganisasian yang lebih baik.
  - Status tautan (`Active`, `Inactive`, `Deleted`).
- **Analitik Klik**:
  - Pelacakan klik secara asinkron (menggunakan Laravel Jobs/Queue) agar tidak menghambat proses redirect.
  - Pencatatan data referer, user agent (browser & perangkat), dan alamat IP.
  - Visualisasi data klik per hari.
- **QR Code Generator**:
  - Menghasilkan QR Code secara otomatis untuk setiap shortlink yang dibuat.
  - Fitur unduh QR Code untuk kebutuhan cetak atau digital.
- **Sistem Autentikasi**:
  - Dashboard pribadi untuk setiap pengguna (menggunakan Laravel Breeze).
  - Manajemen profil dan pengaturan akun.
- **Slug Availability Checker**: Fitur cek ketersediaan slug secara real-time saat pembuatan tautan.

## 🚀 Teknologi yang Digunakan

- **Framework**: Laravel 13
- **Autentikasi**: Laravel Breeze
- **Database**: MySQL / PostgreSQL / SQLite
- **QR Code**: `simplesoftwareio/simple-qrcode`
- **Analytics Helper**: `jenssegers/agent` (untuk deteksi perangkat & browser)
- **ID Generator**: `hashids/hashids`
- **Tooling**: Vite, Composer, NPM, Concurrently

## 🛠️ Instalasi

1. **Clone Repository**
   ```bash
   git clone git@github.com:kodokzzzz/shortlink.git
   cd shortlink
   ```

2. **Instal Dependensi PHP**
   ```bash
   composer install
   ```

3. **Instal Dependensi Frontend**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` ke `.env` dan sesuaikan pengaturan database serta queue driver.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Migrasi Database**
   ```bash
   php artisan migrate
   ```

6. **Jalankan Aplikasi**
   Gunakan perintah `npm run dev` untuk menjalankan server PHP, Vite, dan Queue Worker secara bersamaan (menggunakan Concurrently).
   ```bash
   npm run dev
   ```

## 📋 Alur Kerja (Workflow)

1. **Pengguna** melakukan pendaftaran atau login ke dalam sistem.
2. Melalui dashboard, **Pengguna** memasukkan URL asli dan menentukan slug (opsional).
3. Sistem memvalidasi ketersediaan slug dan menyimpan data tautan.
4. **Tautan Pendek** dan **QR Code** siap digunakan.
5. Setiap kali seseorang mengakses shortlink, sistem akan:
   - Mencatat data klik secara asinkron di background.
   - Mengalihkan pengguna ke URL asli (Redirect 302).
6. **Pengguna** dapat melihat statistik performa tautan melalui dashboard analitik.

## 📄 Lisensi

Proyek ini dikembangkan sebagai alat bantu internal. Silakan merujuk pada file `LICENSE` (jika ada) untuk informasi lebih lanjut.
