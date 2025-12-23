<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample Quiz
        $quiz = Quiz::updateOrCreate(
            ['title' => 'Evaluasi Pemahaman SOP Chain of Custody (CoC)'],
            [
                'description' => 'Kuis ini menguji pemahaman Anda tentang prinsip-prinsip Chain of Custody dalam pengelolaan kayu bersertifikat, termasuk penandaan, pemisahan, dokumentasi, dan ketelusuran.',
                'duration' => 60, // Perpanjang durasi karena soal lebih banyak
                'start_time' => now(),
                'end_time' => now()->addDays(365),
                'status' => 'active',
            ]
        );

        // Hapus soal lama untuk kuis ini agar tidak duplikat saat db:seed ulang
        $quiz->questions()->delete();

        // Data Soal Baru (20 Soal)
        $questions = [
            [
                'q' => 'Tujuan utama penerapan Chain of Custody (CoC) adalah untuk:',
                'options' => [
                    ['text' => 'Mempercepat proses penebangan kayu', 'correct' => false],
                    ['text' => 'Menjamin keterlacakan, legalitas, dan keabsahan asal kayu', 'correct' => true],
                    ['text' => 'Mengurangi biaya produksi kayu', 'correct' => false],
                    ['text' => 'Menambah volume hasil hutan', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Ruang lingkup CoC mencakup proses pergerakan kayu mulai dari:',
                'options' => [
                    ['text' => 'Gudang sampai pabrik', 'correct' => false],
                    ['text' => 'Hutan alam ke pelabuhan', 'correct' => false],
                    ['text' => 'Petak tebangan sampai mill gate', 'correct' => true],
                    ['text' => 'TPK Antara ke industri', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Berikut ini yang bukan termasuk prinsip utama Chain of Custody adalah:',
                'options' => [
                    ['text' => 'Penandaan', 'correct' => false],
                    ['text' => 'Pemisahan', 'correct' => false],
                    ['text' => 'Dokumentasi', 'correct' => false],
                    ['text' => 'Produksi massal', 'correct' => true],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Yang dimaksud dengan Lacak Balak (Chain of Custody) adalah:',
                'options' => [
                    ['text' => 'Sistem pengangkutan kayu berbasis volume', 'correct' => false],
                    ['text' => 'Jalur pergerakan kayu dari petak tebangan sampai mill gate', 'correct' => true],
                    ['text' => 'Proses pemanenan kayu di hutan tanaman', 'correct' => false],
                    ['text' => 'Kegiatan penumpukan kayu di TPK', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'PUHH adalah singkatan dari:',
                'options' => [
                    ['text' => 'Pengukuran Umum Hasil Hutan', 'correct' => false],
                    ['text' => 'Pengelolaan Usaha Hasil Hutan', 'correct' => false],
                    ['text' => 'Penatausahaan Hasil Hutan', 'correct' => true],
                    ['text' => 'Pengawasan Usaha Hutan', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Sistem informasi berbasis web yang digunakan untuk pencatatan dan pelaporan hasil hutan adalah:',
                'options' => [
                    ['text' => 'SIMPONI', 'correct' => false],
                    ['text' => 'SIPNBP', 'correct' => false],
                    ['text' => 'SIPUHH', 'correct' => true],
                    ['text' => 'WOTS', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Tempat pengumpulan kayu hasil pemanenan di sekitar petak tebangan disebut:',
                'options' => [
                    ['text' => 'TPK Antara', 'correct' => false],
                    ['text' => 'TPK Hutan', 'correct' => false],
                    ['text' => 'TPn', 'correct' => true],
                    ['text' => 'Mill Gate', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Simpul terakhir dalam alur pergerakan kayu adalah:',
                'options' => [
                    ['text' => 'TPn', 'correct' => false],
                    ['text' => 'TPK Antara', 'correct' => false],
                    ['text' => 'Pos Faktur', 'correct' => false],
                    ['text' => 'Mill Gate', 'correct' => true],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Dokumen yang memuat data hasil penebangan berdasarkan buku ukur disebut:',
                'options' => [
                    ['text' => 'BCP', 'correct' => false],
                    ['text' => 'SKSHHK', 'correct' => false],
                    ['text' => 'LHP', 'correct' => true],
                    ['text' => 'SPK', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Label tumpukan kayu dipasang setelah kegiatan:',
                'options' => [
                    ['text' => 'Penebangan', 'correct' => false],
                    ['text' => 'Penyaradan', 'correct' => false],
                    ['text' => 'Pengukuran tumpukan', 'correct' => true],
                    ['text' => 'Pengangkutan', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Warna label tumpukan kayu yang digunakan dalam CoC adalah:',
                'options' => [
                    ['text' => 'Merah', 'correct' => false],
                    ['text' => 'Hijau', 'correct' => false],
                    ['text' => 'Biru', 'correct' => false],
                    ['text' => 'Kuning', 'correct' => true],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Kayu yang telah di-LHP-kan dan PSDH-nya sudah dibayar ditandai dengan:',
                'options' => [
                    ['text' => 'Stempel merah', 'correct' => false],
                    ['text' => 'Tanda centang (√)', 'correct' => true],
                    ['text' => 'Kode barcode', 'correct' => false],
                    ['text' => 'Nomor seri tambahan', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'SPK Trip In digunakan untuk pengangkutan kayu dari:',
                'options' => [
                    ['text' => 'Pos faktur ke mill', 'correct' => false],
                    ['text' => 'TPn/tempat transit ke pos faktur', 'correct' => true],
                    ['text' => 'TPK Antara ke industri', 'correct' => false],
                    ['text' => 'TPn ke tempat transit', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Dokumen resmi angkutan hasil hutan kayu yang diterbitkan melalui SIPUHH adalah:',
                'options' => [
                    ['text' => 'SPK', 'correct' => false],
                    ['text' => 'SPA Lansir', 'correct' => false],
                    ['text' => 'SKSHHK', 'correct' => true],
                    ['text' => 'BKMK', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Buku yang mencatat keluar masuknya kayu sebagai dasar neraca kayu disebut:',
                'options' => [
                    ['text' => 'BCP', 'correct' => false],
                    ['text' => 'BKMK', 'correct' => true],
                    ['text' => 'LHP', 'correct' => false],
                    ['text' => 'RKT', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Kayu yang identitasnya tidak diketahui dan tidak dapat ditelusuri disebut:',
                'options' => [
                    ['text' => 'Kayu HTI', 'correct' => false],
                    ['text' => 'Kayu Non-HTI', 'correct' => false],
                    ['text' => 'Uncontrolled Wood', 'correct' => true],
                    ['text' => 'Kayu Sertifikat', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Kayu IFCC-PEFC harus:',
                'options' => [
                    ['text' => 'Dicampur dengan kayu non sertifikat', 'correct' => false],
                    ['text' => 'Disimpan tanpa dokumen', 'correct' => false],
                    ['text' => 'Dipisahkan secara fisik dan dokumen', 'correct' => true],
                    ['text' => 'Tidak perlu label', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Aplikasi internal perusahaan untuk mendukung aktivitas CoC adalah:',
                'options' => [
                    ['text' => 'SIPUHH', 'correct' => false],
                    ['text' => 'SIMPONI', 'correct' => false],
                    ['text' => 'WOTS (Wood Tracking System)', 'correct' => true],
                    ['text' => 'SIPNBP', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Pihak yang bertanggung jawab menunjuk dan menetapkan penanggung jawab CoC adalah:',
                'options' => [
                    ['text' => 'Koordinator CoC Distrik', 'correct' => false],
                    ['text' => 'Tim Juru Ukur', 'correct' => false],
                    ['text' => 'Kepala PBPH', 'correct' => true],
                    ['text' => 'Petugas Pos Faktur', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
            [
                'q' => 'Semua dokumen CoC wajib disimpan minimal selama:',
                'options' => [
                    ['text' => '1 tahun', 'correct' => false],
                    ['text' => '3 tahun', 'correct' => false],
                    ['text' => '5 tahun', 'correct' => true],
                    ['text' => '10 tahun', 'correct' => false],
                ],
                'type' => 'multiple_choice'
            ],
        ];

        foreach ($questions as $q) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $q['q'],
                'type' => $q['type'],
                'score' => 5, // 5 poin per soal x 20 soal = 100
            ]);

            foreach ($q['options'] as $opt) {
                $question->options()->create([
                    'option_text' => $opt['text'],
                    'is_correct' => $opt['correct'],
                ]);
            }
        }
    }
}
