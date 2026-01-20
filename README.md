# ZalvlmaX - Online Quiz Management System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![Railway](https://img.shields.io/badge/Railway-Deploy-blue.svg)](https://railway.app)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE.md)

ZalvlmaX adalah platform kuis online profesional dengan fitur lengkap untuk evaluasi, pembelajaran, dan monitoring realtime. Dengan antarmuka modern dan fitur enterprise-grade, aplikasi ini cocok untuk institusi pendidikan, perusahaan, dan organisasi.

---

## 📋 Fitur Utama

### 🔐 Role-Based Access Control
| Role | Akses |
|------|-------|
| **Super Admin** | Akses penuh ke seluruh sistem, kelola admin & user, pengaturan sistem |
| **Admin** | Kelola kuis, soal, kategori, lihat laporan |
| **User** | Mengerjakan kuis, lihat hasil, lihat leaderboard |

### 🛡️ Dashboard Super Admin
- **Statistik Real-time**: Pantau total kuis, peserta, dan rata-rata nilai secara instan
- **Manajemen User**: CRUD user dengan role assignment (Super Admin, Admin, User)
- **Pengaturan Sistem**: Konfigurasi aplikasi, email, dan keamanan
- **Activity Log**: Pantau semua aktivitas dalam sistem
- **Backup & Restore**: Kelola backup database

### 👨‍💼 Dashboard Admin
- **Manajemen Kuis**: CRUD kuis dengan pengaturan jadwal, durasi, passing score, max attempts
- **Bank Soal**: Dukungan berbagai tipe soal:
  - Pilihan Ganda (Multiple Choice)
  - Benar/Salah (True/False)
  - Jawaban Jamak (Multiple Correct)
  - Essay
  - Isian Singkat (Fill Blank)
- **Kategori Kuis**: Organisasi kuis berdasarkan kategori
- **Monitoring Realtime**: Pantau progress user seperti Quizizz
- **Leaderboard**: Peringkat otomatis berdasarkan nilai tertinggi dan waktu tercepat
- **Export Data**: Unduh laporan dalam format **Excel** dan **PDF**

### 📊 Monitoring Realtime (seperti Quizizz)
- **Live Dashboard**: Pantau user yang sedang mengerjakan kuis
- **Status Soal**: Belum dijawab, dijawab, ditandai untuk review, dilewati
- **Progress Bar**: Visualisasi progress per user
- **Timer**: Countdown waktu per user
- **Notifikasi**: Alert saat user mulai/selesai kuis

### 📈 Analitik & Laporan
- **Rekap per Kuis**: Statistik lengkap setiap kuis
- **Rekap per User**: Performa individu user
- **Rekap per Periode**: Trend harian, mingguan, bulanan
- **Statistik Soal**: Tingkat kesulitan per soal
- **Distribusi Nilai**: Grafik distribusi skor

### 📄 Export & Laporan
- **Excel Export**: Tabel rapi dengan formatting profesional
- **PDF Export**: Layout dokumen profesional dengan header/footer
- **Filter Laporan**: Tanggal, kuis, user, kategori
- **Ringkasan Statistik**: Rata-rata, tertinggi, terendah

### 🎓 Portal Peserta
- **Kuis Aktif**: Daftar kuis yang tersedia
- **Interface Interaktif**: Timer otomatis, navigasi soal
- **Hasil Instan**: Skor dan pembahasan setelah selesai
- **Riwayat Kuis**: Pantau perkembangan belajar
- **Leaderboard**: Bersaing dengan peserta lain

---

## 🛠️ Stack Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel 12.x (PHP 8.2+) |
| Frontend | Bootstrap 5 & Vanilla JS |
| Database | MySQL / MariaDB |
| Auth | Laravel Breeze (Session-based) |
| Asset Bundler | Vite 6+ |
| Realtime | Laravel Reverb / Pusher |
| Excel | Laravel Excel (maatwebsite/excel) |
| PDF | DomPDF (barryvdh/laravel-dompdf) |

---

## 📐 Skema Database

Lihat dokumentasi lengkap di **`docs/DATABASE_SCHEMA.md`** untuk:
- ERD (Entity Relationship Diagram)
- Daftar tabel dan field
- Index untuk performa
- Contoh query analitik

### Tabel Utama

| Tabel | Keterangan |
|-------|------------|
| `users` | Master user dengan role |
| `categories` | Kategori kuis |
| `quizzes` | Master kuis |
| `questions` | Soal per kuis |
| `options` | Pilihan jawaban |
| `quiz_sessions` | Sesi pengerjaan |
| `quiz_progress` | Progress realtime |
| `answers` | Jawaban user |
| `results` | Hasil akhir |
| `quiz_leaderboards` | Cache leaderboard |
| `activity_logs` | Log aktivitas |
| `settings` | Pengaturan sistem |
| `report_exports` | Riwayat ekspor |

---

## 🚀 Panduan Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB

### Langkah-langkah

1. **Clone & Masuk ke Folder**
   ```bash
   cd coc-quiz-app
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Edit `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=zalvlmax_quiz
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Compile Assets & Run**
   ```bash
   npm run build
   php artisan serve
   ```
   Akses di: `http://localhost:8000`

---

## 📦 Library yang Direkomendasikan

### Untuk Excel Export
```bash
composer require maatwebsite/excel
```

### Untuk PDF Export
```bash
composer require barryvdh/laravel-dompdf
```

### Untuk Realtime (Pilih salah satu)

**Laravel Reverb (Built-in):**
```bash
php artisan install:broadcasting
```

**Pusher:**
```bash
composer require pusher/pusher-php-server
npm install --save laravel-echo pusher-js
```

### Untuk Role & Permission
```bash
composer require spatie/laravel-permission
```

### Untuk Activity Log
```bash
composer require spatie/laravel-activitylog
```

---

## ☁️ Deployment ke Railway

1. Hubungkan repo GitHub ke Railway
2. Tambahkan variabel lingkungan:
   - `APP_KEY`: Hasil dari `php artisan key:generate --show`
   - `APP_ENV`: `production`
   - `APP_URL`: `https://your-app.up.railway.app`
   - `DB_CONNECTION`: `mysql`
   - Kredensial DB dari Railway
3. Jalankan migrasi: `php artisan migrate --force --seed`

---

## 👤 Akun Default

| Role | Email | Password |
|------|-------|----------|
| **Super Admin** | `superadmin@zalvlmax.com` | `superadmin123` |
| **Admin** | `admin@zalvlmax.com` | `admin123` |
| **User** | `john@example.com` | `password` |

---

## 📚 Alur Sistem Super Admin

```
Login → Dashboard → Statistik & Monitoring
                  → Manajemen User (CRUD + Role Assignment)
                  → Manajemen Kuis (via Admin)
                  → Monitoring Realtime
                  → Analitik & Peringkat
                  → Laporan (Filter + Export)
                  → Pengaturan Sistem
                  → Logout
```

Lihat alur lengkap di **`docs/DATABASE_SCHEMA.md`**

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah lisensi MIT.

Created with ❤️ by **ZalvlmaX Team**

