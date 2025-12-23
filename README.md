# CoC Quiz Application - Aplikasi Evaluasi dan Kuis Chain of Custody

Aplikasi web berbasis Laravel untuk evaluasi dan kuis pembelajaran SOP Chain of Custody (CoC) dengan konsep mirip Quizizz.

## 📋 Fitur Utama

### Role Admin
- ✅ Dashboard dengan statistik lengkap (total kuis, peserta, rata-rata nilai, grafik)
- ✅ CRUD Kuis (judul, deskripsi, durasi, jadwal, status)
- ✅ CRUD Soal (pilihan ganda, benar/salah, multiple correct)
- ✅ CRUD Opsi Jawaban dengan penentuan jawaban benar
- ✅ Melihat hasil evaluasi seluruh peserta
- ✅ Leaderboard/ranking peserta per kuis
- ✅ Export hasil evaluasi ke Excel dan PDF
- ✅ Manajemen user (aktif/nonaktif, reset password)

### Role User (Peserta)
- ✅ Melihat daftar kuis aktif
- ✅ Mengerjakan kuis sesuai durasi
- ✅ Menjawab soal satu per satu secara interaktif
- ✅ Melihat nilai setelah selesai
- ✅ Melihat riwayat kuis
- ✅ Melihat leaderboard

## 🛠️ Teknologi

- **Framework**: Laravel 11.x
- **PHP**: 8.1+
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Breeze
- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5
- **Export**: Laravel Excel & DomPDF

## 📦 Instalasi

### Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)

### Langkah Instalasi

1. **Clone atau extract project**
   ```bash
   cd coc-quiz-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**
   
   Edit file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=coc_quiz_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Buat database**
   ```sql
   CREATE DATABASE coc_quiz_db;
   ```

6. **Jalankan migration dan seeder**
   ```bash
   php artisan migrate --seed
   ```

7. **Compile assets**
   ```bash
   npm run dev
   ```

8. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

9. **Akses aplikasi**
   
   Buka browser: `http://localhost:8000`

## 👤 Default Users

### Admin
- Email: `admin@coc-quiz.com`
- Password: `admin123`

### User (Peserta)
- Email: `john@example.com`
- Password: `password`

- Email: `jane@example.com`
- Password: `password`

- Email: `bob@example.com`
- Password: `password`

## 📁 Struktur Database

### Tabel Users
- id, name, email, password, role (admin/user), is_active

### Tabel Quizzes
- id, title, description, duration, start_time, end_time, status

### Tabel Questions
- id, quiz_id, question_text, type (multiple_choice/true_false/multiple_correct), score

### Tabel Options
- id, question_id, option_text, is_correct

### Tabel Answers
- id, user_id, question_id, option_id

### Tabel Results
- id, user_id, quiz_id, total_score, correct_answers, wrong_answers, completion_time

## 🎯 Cara Penggunaan

### Untuk Admin

1. **Login** sebagai admin
2. **Dashboard**: Lihat statistik keseluruhan
3. **Kelola Kuis**: 
   - Klik "Kelola Kuis" di sidebar
   - Tambah kuis baru dengan tombol "Tambah Kuis"
   - Atur judul, deskripsi, durasi, dan jadwal
4. **Kelola Soal**:
   - Dari halaman kuis, klik "Kelola Soal"
   - Tambah soal dengan berbagai tipe
   - Tambahkan opsi jawaban dan tandai yang benar
5. **Lihat Hasil**:
   - Klik "Hasil Evaluasi" di sidebar
   - Filter berdasarkan kuis
   - Export ke Excel atau PDF
6. **Kelola User**:
   - Aktifkan/nonaktifkan user
   - Reset password user

### Untuk User (Peserta)

1. **Login** sebagai user
2. **Dashboard**: Lihat statistik personal
3. **Daftar Kuis**:
   - Klik "Kuis" di menu
   - Pilih kuis yang aktif
4. **Mengerjakan Kuis**:
   - Klik "Mulai Kuis"
   - Jawab soal satu per satu
   - Waktu akan berjalan otomatis
5. **Lihat Hasil**:
   - Setelah selesai, lihat nilai dan pembahasan
   - Cek posisi di leaderboard
6. **Riwayat**:
   - Lihat semua kuis yang pernah dikerjakan

## 🔒 Middleware & Authorization

- **AdminMiddleware**: Memastikan hanya admin yang akses route admin
- **UserMiddleware**: Memastikan hanya user biasa yang akses route user
- **Auth Middleware**: Memastikan user sudah login

## 📊 Export Fitur

### Export Excel
- Format tabel rapi dengan header
- Berisi: Nama, Email, Kuis, Skor, Jawaban Benar/Salah, Waktu
- Route: `/admin/results/export/excel`

### Export PDF
- Layout profesional
- Informasi lengkap hasil evaluasi
- Route: `/admin/results/export/pdf`

## 🎨 Konten Soal CoC

Aplikasi sudah dilengkapi dengan 10 soal sample tentang:
- Prinsip Chain of Custody
- Penandaan dan pemisahan kayu
- Dokumentasi (LHP, SKSHHK, SPK, SPA, BKMK)
- Alur pergerakan kayu
- Tanggung jawab CoC
- IFCC-PEFC dan Uncontrolled Wood

## 🚀 Routes

### Admin Routes (Prefix: /admin)
- GET `/admin/dashboard` - Dashboard admin
- Resource `/admin/quizzes` - CRUD Kuis
- GET `/admin/quizzes/{quiz}/questions` - Daftar soal
- POST `/admin/quizzes/{quiz}/questions` - Tambah soal
- GET `/admin/results` - Hasil evaluasi
- GET `/admin/results/export/excel` - Export Excel
- GET `/admin/results/export/pdf` - Export PDF
- GET `/admin/users` - Manajemen user

### User Routes (Prefix: /user)
- GET `/user/dashboard` - Dashboard user
- GET `/user/quizzes` - Daftar kuis
- POST `/user/quizzes/{quiz}/start` - Mulai kuis
- POST `/user/quizzes/{quiz}/question/{question}/submit` - Submit jawaban
- GET `/user/results` - Riwayat hasil
- GET `/user/leaderboard/{quiz?}` - Leaderboard

## 🔧 Service Classes

### QuizService
- `calculateResult()` - Hitung hasil quiz
- `getLeaderboard()` - Ambil leaderboard per quiz
- `getGlobalLeaderboard()` - Leaderboard global
- `hasUserTakenQuiz()` - Cek apakah user sudah mengerjakan
- `getUserProgress()` - Progress pengerjaan user
- `resetQuizAttempt()` - Reset attempt untuk retake

## 📝 Models & Relationships

- **User**: hasMany(Answer, Result)
- **Quiz**: hasMany(Question, Result)
- **Question**: belongsTo(Quiz), hasMany(Option, Answer)
- **Option**: belongsTo(Question), hasMany(Answer)
- **Answer**: belongsTo(User, Question, Option)
- **Result**: belongsTo(User, Quiz)

## ⚡ Performance Optimization

- Eager loading untuk menghindari N+1 query
- Pagination pada semua listing
- Index pada foreign keys
- Caching untuk leaderboard (optional)

## 🐛 Troubleshooting

### Error: Class not found
```bash
composer dump-autoload
```

### Error: Migration failed
```bash
php artisan migrate:fresh --seed
```

### Error: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

## 📄 License

This project is open-sourced software licensed under the MIT license.

## 👨‍💻 Developer

Developed with ❤️ for Chain of Custody Learning

---

**Note**: Aplikasi ini production-ready dengan clean code, scalable architecture, dan mengikuti best practices Laravel.
