# 📊 Skema Database Sistem Kuis Online - ZalvlmaX

## Overview
Database ini dirancang untuk sistem kuis online dengan fitur lengkap termasuk monitoring realtime, analitik, dan pelaporan. Menggunakan MySQL dengan relasi yang jelas dan efisien serta siap untuk skala besar.

---

## 📋 Daftar Tabel Utama

### 1. Tabel Master

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Master data pengguna dengan role-based access |
| `roles` | Definisi peran (super_admin, admin, user) |
| `permissions` | Definisi hak akses |
| `role_permissions` | Pivot table role-permission |
| `categories` | Kategori kuis |
| `settings` | Pengaturan sistem |

### 2. Tabel Kuis

| Tabel | Deskripsi |
|-------|-----------|
| `quizzes` | Master data kuis |
| `questions` | Soal-soal dalam kuis |
| `options` | Pilihan jawaban untuk setiap soal |
| `quiz_sessions` | Sesi pengerjaan kuis per user |
| `quiz_attempts` | Percobaan pengerjaan kuis |

### 3. Tabel Aktivitas & Hasil

| Tabel | Deskripsi |
|-------|-----------|
| `answers` | Jawaban user per soal |
| `results` | Hasil akhir kuis per user |
| `activity_logs` | Log aktivitas sistem |
| `quiz_progress` | Progress realtime pengerjaan |

### 4. Tabel Laporan

| Tabel | Deskripsi |
|-------|-----------|
| `report_exports` | Riwayat ekspor laporan |
| `statistics_cache` | Cache untuk statistik |

---

## 📐 Entity Relationship Diagram (ERD)

```
┌─────────────────┐                    ┌─────────────────┐
│     roles       │                    │   permissions   │
│─────────────────│                    │─────────────────│
│ id              │─────┐  ┌───────────│ id              │
│ name            │     │  │           │ name            │
│ display_name    │     │  │           │ slug            │
│ description     │     │  │           │ module          │
└─────────────────┘     │  │           └─────────────────┘
                        │  │
                        ▼  ▼
              ┌──────────────────────┐
              │   role_permissions   │
              │──────────────────────│
              │ role_id (FK)         │
              │ permission_id (FK)   │
              └──────────────────────┘

┌─────────────────┐
│     users       │
│─────────────────│
│ id              │
│ name            │
│ email           │──────────────────────────────────────────┐
│ password        │                                          │
│ role            │                                          │
│ avatar          │                                          │
│ phone           │                                          │
│ is_active       │                                          │
│ last_login_at   │                                          │
└─────────────────┘                                          │
        │                                                    │
        │ 1:N                                                │
        ▼                                                    │
┌─────────────────┐          ┌─────────────────┐            │
│ quiz_sessions   │          │    quizzes      │            │
│─────────────────│          │─────────────────│            │
│ id              │◄─────────│ id              │            │
│ user_id (FK)    │          │ title           │            │
│ quiz_id (FK)    │          │ description     │            │
│ started_at      │          │ category_id     │◄───────────┤
│ completed_at    │          │ duration        │            │
│ status          │          │ passing_score   │            │
│ current_question│          │ max_attempts    │            │
└─────────────────┘          │ shuffle_questions│           │
        │                    │ shuffle_options │            │
        │ 1:N                │ show_result     │            │
        ▼                    │ created_by      │────────────┘
┌─────────────────┐          │ status          │
│ quiz_progress   │          └─────────────────┘
│─────────────────│                  │
│ id              │                  │ 1:N
│ session_id (FK) │                  ▼
│ question_id (FK)│          ┌─────────────────┐
│ status          │          │   questions     │
│ time_spent      │          │─────────────────│
│ answered_at     │          │ id              │
└─────────────────┘          │ quiz_id (FK)    │
                             │ question_text   │
                             │ type            │
                             │ score           │
                             │ order           │
                             │ explanation     │
                             └─────────────────┘
                                     │
                                     │ 1:N
                                     ▼
                             ┌─────────────────┐
                             │    options      │
                             │─────────────────│
                             │ id              │
                             │ question_id (FK)│
                             │ option_text     │
                             │ is_correct      │
                             │ order           │
                             └─────────────────┘
```

---

## 📝 Detail Field per Tabel

### 1. Tabel `users`
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'admin', 'user') DEFAULT 'user',
    avatar VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_role (role),
    INDEX idx_is_active (is_active),
    INDEX idx_email (email)
) ENGINE=InnoDB;
```

### 2. Tabel `categories`
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    icon VARCHAR(50) NULL,
    color VARCHAR(7) NULL COMMENT 'Hex color code',
    parent_id BIGINT UNSIGNED NULL,
    is_active BOOLEAN DEFAULT TRUE,
    order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB;
```

### 3. Tabel `quizzes`
```sql
CREATE TABLE quizzes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE COMMENT 'UUID untuk public access',
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    category_id BIGINT UNSIGNED NULL,
    duration INT NOT NULL COMMENT 'Durasi dalam menit',
    passing_score DECIMAL(5,2) DEFAULT 60.00 COMMENT 'Nilai minimum kelulusan',
    max_attempts INT DEFAULT 1 COMMENT 'Maksimal percobaan',
    shuffle_questions BOOLEAN DEFAULT FALSE,
    shuffle_options BOOLEAN DEFAULT FALSE,
    show_result ENUM('immediately', 'after_end', 'never') DEFAULT 'immediately',
    show_correct_answer BOOLEAN DEFAULT FALSE,
    start_time DATETIME NULL,
    end_time DATETIME NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    status ENUM('draft', 'active', 'inactive', 'archived') DEFAULT 'draft',
    featured_image VARCHAR(255) NULL,
    access_type ENUM('public', 'private', 'password') DEFAULT 'public',
    access_password VARCHAR(255) NULL,
    meta JSON NULL COMMENT 'Metadata tambahan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_category (category_id),
    INDEX idx_uuid (uuid),
    INDEX idx_created_by (created_by),
    INDEX idx_start_end (start_time, end_time)
) ENGINE=InnoDB;
```

### 4. Tabel `questions`
```sql
CREATE TABLE questions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quiz_id BIGINT UNSIGNED NOT NULL,
    question_text TEXT NOT NULL,
    type ENUM('multiple_choice', 'true_false', 'multiple_correct', 'essay', 'fill_blank') DEFAULT 'multiple_choice',
    score INT DEFAULT 10 COMMENT 'Bobot nilai soal',
    negative_score INT DEFAULT 0 COMMENT 'Pengurangan nilai jika salah',
    time_limit INT NULL COMMENT 'Waktu per soal dalam detik (opsional)',
    order INT DEFAULT 0,
    explanation TEXT NULL COMMENT 'Penjelasan jawaban benar',
    image VARCHAR(255) NULL,
    is_required BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    INDEX idx_quiz_id (quiz_id),
    INDEX idx_order (order)
) ENGINE=InnoDB;
```

### 5. Tabel `options`
```sql
CREATE TABLE options (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question_id BIGINT UNSIGNED NOT NULL,
    option_text TEXT NOT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    order INT DEFAULT 0,
    image VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    INDEX idx_question_id (question_id),
    INDEX idx_is_correct (is_correct)
) ENGINE=InnoDB;
```

### 6. Tabel `quiz_sessions`
```sql
CREATE TABLE quiz_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    quiz_id BIGINT UNSIGNED NOT NULL,
    attempt_number INT DEFAULT 1,
    started_at TIMESTAMP NOT NULL,
    completed_at TIMESTAMP NULL,
    expires_at TIMESTAMP NOT NULL COMMENT 'Waktu berakhir sesi',
    status ENUM('in_progress', 'completed', 'expired', 'abandoned') DEFAULT 'in_progress',
    current_question_index INT DEFAULT 0,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    browser_info JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_active_session (user_id, quiz_id, status),
    INDEX idx_user_quiz (user_id, quiz_id),
    INDEX idx_status (status),
    INDEX idx_uuid (uuid)
) ENGINE=InnoDB;
```

### 7. Tabel `quiz_progress` (Untuk Monitoring Realtime)
```sql
CREATE TABLE quiz_progress (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id BIGINT UNSIGNED NOT NULL,
    question_id BIGINT UNSIGNED NOT NULL,
    status ENUM('not_visited', 'visited', 'answered', 'marked_review', 'skipped') DEFAULT 'not_visited',
    time_spent INT DEFAULT 0 COMMENT 'Waktu dihabiskan dalam detik',
    visited_at TIMESTAMP NULL,
    answered_at TIMESTAMP NULL,
    last_activity_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (session_id) REFERENCES quiz_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_session_question (session_id, question_id),
    INDEX idx_session_id (session_id),
    INDEX idx_status (status)
) ENGINE=InnoDB;
```

### 8. Tabel `answers`
```sql
CREATE TABLE answers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    question_id BIGINT UNSIGNED NOT NULL,
    option_id BIGINT UNSIGNED NULL COMMENT 'NULL untuk essay/fill_blank',
    selected_options JSON NULL COMMENT 'Untuk multiple_correct',
    essay_answer TEXT NULL COMMENT 'Untuk essay/fill_blank',
    is_correct BOOLEAN NULL,
    score_obtained DECIMAL(8,2) DEFAULT 0,
    answered_at TIMESTAMP NOT NULL,
    time_spent INT DEFAULT 0 COMMENT 'Waktu dalam detik',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (session_id) REFERENCES quiz_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES options(id) ON DELETE SET NULL,
    UNIQUE KEY unique_answer (session_id, question_id),
    INDEX idx_user_question (user_id, question_id),
    INDEX idx_is_correct (is_correct)
) ENGINE=InnoDB;
```

### 9. Tabel `results`
```sql
CREATE TABLE results (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id BIGINT UNSIGNED NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    quiz_id BIGINT UNSIGNED NOT NULL,
    total_score DECIMAL(8,2) DEFAULT 0,
    max_score DECIMAL(8,2) DEFAULT 0,
    percentage DECIMAL(5,2) DEFAULT 0,
    correct_answers INT DEFAULT 0,
    wrong_answers INT DEFAULT 0,
    unanswered INT DEFAULT 0,
    total_questions INT DEFAULT 0,
    completion_time INT NULL COMMENT 'Waktu pengerjaan dalam detik',
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    is_passed BOOLEAN DEFAULT FALSE,
    rank INT NULL COMMENT 'Peringkat otomatis',
    percentile DECIMAL(5,2) NULL COMMENT 'Persentil dalam populasi',
    certificate_id VARCHAR(50) NULL,
    reviewed_by BIGINT UNSIGNED NULL,
    reviewed_at TIMESTAMP NULL,
    notes TEXT NULL COMMENT 'Catatan dari reviewer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (session_id) REFERENCES quiz_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_quiz (user_id, quiz_id),
    INDEX idx_score (total_score DESC),
    INDEX idx_percentage (percentage DESC),
    INDEX idx_completion_time (completion_time ASC),
    INDEX idx_rank (rank),
    INDEX idx_is_passed (is_passed)
) ENGINE=InnoDB;
```

### 10. Tabel `activity_logs`
```sql
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    loggable_type VARCHAR(255) NULL COMMENT 'Polymorphic relation type',
    loggable_id BIGINT UNSIGNED NULL COMMENT 'Polymorphic relation id',
    action VARCHAR(50) NOT NULL COMMENT 'create, update, delete, login, logout, etc',
    description TEXT NULL,
    properties JSON NULL COMMENT 'Data perubahan',
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_loggable (loggable_type, loggable_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB;
```

### 11. Tabel `settings`
```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key VARCHAR(255) NOT NULL UNIQUE,
    value TEXT NULL,
    type ENUM('string', 'integer', 'boolean', 'json', 'file') DEFAULT 'string',
    group VARCHAR(50) DEFAULT 'general',
    description TEXT NULL,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_key (key),
    INDEX idx_group (group)
) ENGINE=InnoDB;
```

### 12. Tabel `report_exports`
```sql
CREATE TABLE report_exports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type ENUM('excel', 'pdf', 'csv') NOT NULL,
    report_type VARCHAR(50) NOT NULL COMMENT 'quiz_results, user_activity, statistics, etc',
    filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT NULL,
    filters JSON NULL COMMENT 'Filter yang digunakan',
    status ENUM('pending', 'processing', 'completed', 'failed') DEFAULT 'pending',
    error_message TEXT NULL,
    downloaded_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_type (type)
) ENGINE=InnoDB;
```

### 13. Tabel `roles` (Opsional jika menggunakan Spatie Permission)
```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    display_name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    guard_name VARCHAR(255) DEFAULT 'web',
    level INT DEFAULT 0 COMMENT 'Hierarchy level',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
```

### 14. Tabel `permissions` (Opsional jika menggunakan Spatie Permission)
```sql
CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    display_name VARCHAR(255) NOT NULL,
    module VARCHAR(50) NOT NULL COMMENT 'users, quizzes, reports, settings',
    guard_name VARCHAR(255) DEFAULT 'web',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_module (module)
) ENGINE=InnoDB;
```

### 15. Tabel `role_permissions` (Pivot)
```sql
CREATE TABLE role_permissions (
    role_id BIGINT UNSIGNED NOT NULL,
    permission_id BIGINT UNSIGNED NOT NULL,
    
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB;
```

### 16. Tabel `quiz_leaderboards` (Cache Leaderboard)
```sql
CREATE TABLE quiz_leaderboards (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quiz_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    result_id BIGINT UNSIGNED NOT NULL,
    rank INT NOT NULL,
    total_score DECIMAL(8,2) NOT NULL,
    completion_time INT NOT NULL,
    calculated_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (result_id) REFERENCES results(id) ON DELETE CASCADE,
    UNIQUE KEY unique_quiz_user (quiz_id, user_id),
    INDEX idx_quiz_rank (quiz_id, rank),
    INDEX idx_score_time (total_score DESC, completion_time ASC)
) ENGINE=InnoDB;
```

---

## 🔐 Hak Akses Role

### Super Admin
- Full access ke semua fitur
- Kelola admin dan user
- Kelola pengaturan sistem
- Akses semua laporan
- Backup dan restore database

### Admin
- Kelola kuis (CRUD)
- Kelola kategori
- Kelola user biasa
- Lihat laporan kuis yang dibuat
- Monitoring progress user

### User
- Mengerjakan kuis
- Lihat hasil sendiri
- Lihat leaderboard
- Update profil sendiri

---

## 📈 Index untuk Performa

```sql
-- Composite indexes untuk query yang sering digunakan
CREATE INDEX idx_results_ranking ON results(quiz_id, total_score DESC, completion_time ASC);
CREATE INDEX idx_answers_analysis ON answers(question_id, is_correct);
CREATE INDEX idx_sessions_active ON quiz_sessions(status, expires_at);
CREATE INDEX idx_progress_realtime ON quiz_progress(session_id, status, last_activity_at);
```

---

## 🚀 Rekomendasi Library Laravel

### 1. Excel Export
- **Laravel Excel (maatwebsite/excel)** - https://github.com/SpartnerNL/Laravel-Excel
  - Export/import Excel dengan mudah
  - Support untuk styling, charts, dan formulas
  - Chunking untuk data besar

### 2. PDF Generation
- **DomPDF (barryvdh/laravel-dompdf)** - https://github.com/barryvdh/laravel-dompdf
  - Mudah digunakan
  - Support CSS styling
  - Cocok untuk layout dokumen
  
- **Laravel Snappy (barryvdh/laravel-snappy)** - https://github.com/barryvdh/laravel-snappy
  - Render HTML ke PDF dengan webkit
  - Lebih akurat untuk layout kompleks

### 3. Realtime
- **Laravel Reverb** (Official Laravel)
  - WebSocket server bawaan Laravel
  - Mudah dikonfigurasi
  - Cocok untuk real-time monitoring

- **Pusher** (pusher/pusher-php-server)
  - Layanan WebSocket terkelola
  - Mudah diintegrasikan
  - Skalabel

- **Laravel Echo + Socket.io**
  - Open source
  - Fleksibel

### 4. Role & Permission
- **Spatie Laravel Permission** - https://github.com/spatie/laravel-permission
  - Standar industri
  - Fitur lengkap
  - Mudah digunakan

### 5. Activity Log
- **Spatie Laravel Activitylog** - https://github.com/spatie/laravel-activitylog
  - Log semua aktivitas
  - Polymorphic relations
  - Searchable

### 6. Lainnya
- **Laravel Horizon** - Job queue monitoring
- **Laravel Telescope** - Debug dan monitoring
- **Laravel Breeze/Jetstream** - Authentication starter kit

---

## 📋 Alur Super Admin

```
┌─────────────────────────────────────────────────────────────────────┐
│                         SUPER ADMIN FLOW                            │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  1. LOGIN                                                           │
│     └── Validasi credentials                                        │
│         └── Check role = super_admin                                │
│             └── Redirect ke Super Admin Dashboard                   │
│                                                                     │
│  2. DASHBOARD                                                        │
│     ├── Statistik Ringkasan                                         │
│     │   ├── Total Users (Super Admin, Admin, User)                  │
│     │   ├── Total Kuis (Active/Inactive)                            │
│     │   ├── Total Pengerjaan Hari Ini                               │
│     │   └── Rata-rata Nilai                                         │
│     │                                                               │
│     ├── Monitoring Realtime                                         │
│     │   ├── User sedang mengerjakan kuis                            │
│     │   ├── Progress per user                                       │
│     │   └── Status: belum dijawab, dijawab, selesai                 │
│     │                                                               │
│     └── Grafik & Charts                                             │
│         ├── Trend pengerjaan kuis (mingguan/bulanan)                │
│         ├── Distribusi nilai                                        │
│         └── Aktivitas per jam                                       │
│                                                                     │
│  3. MANAJEMEN USER                                                  │
│     ├── Daftar User (filter: role, status)                          │
│     ├── Tambah User Baru                                            │
│     │   ├── Assign Role (super_admin, admin, user)                  │
│     │   └── Set Status (active/inactive)                            │
│     ├── Edit User                                                   │
│     ├── Reset Password                                              │
│     └── Hapus User                                                  │
│                                                                     │
│  4. MANAJEMEN KUIS                                                  │
│     ├── Daftar Kuis (filter: status, kategori)                      │
│     ├── Buat Kuis Baru                                              │
│     │   ├── Info dasar (judul, deskripsi, kategori)                 │
│     │   ├── Pengaturan (durasi, passing score, max attempts)        │
│     │   ├── Jadwal (start/end time)                                 │
│     │   └── Status (draft, active, inactive)                        │
│     ├── Kelola Soal                                                 │
│     │   ├── Tambah soal (multiple choice, true/false, dll)          │
│     │   ├── Set bobot nilai per soal                                │
│     │   └── Tambah penjelasan jawaban                               │
│     └── Preview Kuis                                                │
│                                                                     │
│  5. MONITORING REALTIME                                             │
│     ├── Live Dashboard                                              │
│     │   ├── Daftar user yang sedang mengerjakan                     │
│     │   ├── Timer countdown per user                                │
│     │   └── Progress bar per user                                   │
│     ├── Detail Progress per User                                    │
│     │   ├── Soal yang sudah dijawab                                 │
│     │   ├── Soal yang dilewati                                      │
│     │   └── Waktu per soal                                          │
│     └── Notifikasi                                                  │
│         ├── User mulai kuis                                         │
│         ├── User selesai kuis                                       │
│         └── Waktu hampir habis                                      │
│                                                                     │
│  6. ANALITIK & PERINGKAT                                            │
│     ├── Leaderboard                                                 │
│     │   ├── Per kuis                                                │
│     │   ├── Per kategori                                            │
│     │   └── Overall                                                 │
│     ├── Statistik Soal                                              │
│     │   ├── Persentase jawaban benar per soal                       │
│     │   └── Soal tersulit/termudah                                  │
│     └── Trend Analysis                                              │
│         ├── Performa user dari waktu ke waktu                       │
│         └── Perbandingan antar kuis                                 │
│                                                                     │
│  7. LAPORAN                                                         │
│     ├── Filter Laporan                                              │
│     │   ├── Rentang tanggal                                         │
│     │   ├── Kuis tertentu                                           │
│     │   ├── User tertentu                                           │
│     │   └── Kategori                                                │
│     ├── Jenis Laporan                                               │
│     │   ├── Rekap nilai per kuis                                    │
│     │   ├── Rekap nilai per user                                    │
│     │   ├── Rekap nilai per periode                                 │
│     │   └── Ringkasan statistik                                     │
│     └── Ekspor                                                      │
│         ├── Excel (.xlsx) - tabel rapi                              │
│         └── PDF - layout profesional                                │
│                                                                     │
│  8. PENGATURAN                                                      │
│     ├── Pengaturan Umum                                             │
│     │   ├── Nama aplikasi                                           │
│     │   ├── Logo                                                    │
│     │   └── Timezone                                                │
│     ├── Pengaturan Email                                            │
│     │   ├── SMTP configuration                                      │
│     │   └── Email templates                                         │
│     └── Backup Database                                             │
│         ├── Manual backup                                           │
│         └── Schedule backup                                         │
│                                                                     │
│  9. LOGOUT                                                          │
│     └── Clear session                                               │
│         └── Log activity                                            │
│             └── Redirect ke login page                              │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 🔄 Flow Realtime Monitoring (seperti Quizizz)

```
┌───────────────────────────────────────────────────────────────────┐
│                    REALTIME MONITORING FLOW                       │
├───────────────────────────────────────────────────────────────────┤
│                                                                   │
│  USER SIDE                          ADMIN/SUPER ADMIN SIDE        │
│  ==========                         =====================         │
│                                                                   │
│  ┌─────────────┐                    ┌─────────────────────┐       │
│  │ User Login  │                    │ Monitor Dashboard    │       │
│  └──────┬──────┘                    └──────────┬──────────┘       │
│         │                                      │                  │
│         ▼                                      │                  │
│  ┌─────────────┐     WebSocket      ┌──────────▼──────────┐       │
│  │ Start Quiz  │────────────────────│ User Joined Event    │       │
│  └──────┬──────┘                    │ - Show user card     │       │
│         │                           │ - Timer started      │       │
│         │                           └──────────┬──────────┘       │
│         ▼                                      │                  │
│  ┌─────────────┐     WebSocket      ┌──────────▼──────────┐       │
│  │ Answer Q1   │────────────────────│ Progress Update      │       │
│  └──────┬──────┘                    │ - Question #1 ✓      │       │
│         │                           │ - Time: 45 seconds   │       │
│         │                           └──────────┬──────────┘       │
│         ▼                                      │                  │
│  ┌─────────────┐     WebSocket      ┌──────────▼──────────┐       │
│  │ Answer Q2   │────────────────────│ Progress Update      │       │
│  └──────┬──────┘                    │ - Question #2 ✓      │       │
│         │                           │ - 2/10 completed     │       │
│         │                           └──────────┬──────────┘       │
│         ▼                                      │                  │
│  ┌─────────────┐     WebSocket      ┌──────────▼──────────┐       │
│  │ Skip Q3     │────────────────────│ Progress Update      │       │
│  └──────┬──────┘                    │ - Question #3 ⊘      │       │
│         │                           │ - Skipped            │       │
│         │                           └──────────┬──────────┘       │
│         ▼                                      │                  │
│  ┌─────────────┐     WebSocket      ┌──────────▼──────────┐       │
│  │ Submit Quiz │────────────────────│ Quiz Completed       │       │
│  └─────────────┘                    │ - Final score: 85%   │       │
│                                     │ - Time: 8:45         │       │
│                                     │ - Update leaderboard │       │
│                                     └─────────────────────┘       │
│                                                                   │
└───────────────────────────────────────────────────────────────────┘

Status Legend:
✓ Answered    ⊘ Skipped    ○ Not Visited    ★ Marked for Review
```

---

## 📊 Contoh Query Analitik

### Leaderboard dengan Ranking
```sql
SELECT 
    u.name,
    r.total_score,
    r.completion_time,
    r.percentage,
    RANK() OVER (ORDER BY r.total_score DESC, r.completion_time ASC) as rank
FROM results r
JOIN users u ON r.user_id = u.id
WHERE r.quiz_id = ?
ORDER BY rank;
```

### Statistik per Kuis
```sql
SELECT 
    q.title,
    COUNT(*) as total_attempts,
    AVG(r.percentage) as avg_score,
    MAX(r.percentage) as highest_score,
    MIN(r.percentage) as lowest_score,
    AVG(r.completion_time) as avg_time
FROM results r
JOIN quizzes q ON r.quiz_id = q.id
WHERE r.completed_at BETWEEN ? AND ?
GROUP BY q.id;
```

### Progress Realtime per Session
```sql
SELECT 
    qs.id as session_id,
    u.name as user_name,
    q.title as quiz_title,
    qs.started_at,
    TIMESTAMPDIFF(SECOND, qs.started_at, NOW()) as elapsed_time,
    COUNT(CASE WHEN qp.status = 'answered' THEN 1 END) as answered,
    COUNT(CASE WHEN qp.status = 'not_visited' THEN 1 END) as not_visited,
    COUNT(CASE WHEN qp.status = 'skipped' THEN 1 END) as skipped,
    COUNT(*) as total_questions
FROM quiz_sessions qs
JOIN users u ON qs.user_id = u.id
JOIN quizzes q ON qs.quiz_id = q.id
LEFT JOIN quiz_progress qp ON qs.id = qp.session_id
WHERE qs.status = 'in_progress'
GROUP BY qs.id;
```

---

Dokumen ini menyediakan panduan lengkap untuk implementasi database sistem kuis online dengan Laravel dan MySQL.
