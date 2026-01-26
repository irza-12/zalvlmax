<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GanisPKBQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Kategori (jika belum ada)
        $category = Category::firstOrCreate(
            ['name' => 'Kehutanan & Lingkungan'],
            [
                'description' => 'Materi Sertifikasi Tenaga Teknis Pengelolaan Hutan',
                'icon' => 'tree', // Bootstrap icon
                'color' => '#166534', // Green-800
                'is_active' => true,
            ]
        );

        // 2. Buat Quiz Ganis PKB
        $quiz = Quiz::create([
            'uuid' => Str::uuid(),
            'category_id' => $category->id,
            'title' => 'Ujian Sertifikasi Ganis PKB - Level Profesional',
            'description' => 'Ujian kompetensi untuk Tenaga Teknis Pengelolaan Hutan Pengujian Kayu Bulat (GanisPHPL-PKB). Materi mencakup identifikasi jenis, pengukuran dimensi, penetapan isi, dan pengujian cacat kayu bulat sesuai SNI.',
            'duration' => 60, // 60 menit
            'passing_score' => 70, // Passing grade 70%
            'max_attempts' => 3,
            'status' => 'active',
            'access_type' => 'public',
            'access_password' => '789123', // Kode akses angka 6 digit
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'show_correct_answer' => false,
        ]);

        // 3. Daftar 20 Soal Ganis PKB
        $questions = [
            [
                'question' => 'Sesuai dengan SNI 7533.1:2010 tentang Kayu Bulat Bagian 1: Istilah dan Definisi, yang dimaksud dengan "Bontos" adalah...',
                'options' => [
                    ['text' => 'Permukaan kayu pada ujung-ujung kayu bulat yang merupakan bidang irisan melintang', 'correct' => true],
                    ['text' => 'Bagian kayu yang berada di bawah kulit', 'correct' => false],
                    ['text' => 'Cacat kayu yang disebabkan oleh serangga', 'correct' => false],
                    ['text' => 'Lapisan kayu gubal yang berwarna terang', 'correct' => false],
                ],
            ],
            [
                'question' => 'Dalam pengukuran kayu bulat rimba, diameter pangkal (dp) diukur pada jarak berapa dari bontos pangkal?',
                'options' => [
                    ['text' => 'Tepat pada bontos pangkal', 'correct' => false],
                    ['text' => '10 cm dari bontos pangkal', 'correct' => false],
                    ['text' => '20 cm dari bontos pangkal', 'correct' => false],
                    ['text' => 'Terpendek dan terpanjang melalui pusat bontos (rata-rata)', 'correct' => true],
                ],
                'note' => 'Penjelasan: Diameter diukur pada kedua bontos (pangkal dan ujung) dengan mengambil rata-rata garis tengah terpendek dan terpanjang (d1+d2)/2.'
            ],
            [
                'question' => 'Rumus perhitungan volume kayu bulat rimba (Smalian) yang benar untuk panjang (L) dalam meter dan diameter (d) dalam centimeter adalah...',
                'options' => [
                    ['text' => 'V = 0,7854 × d² × L / 10.000', 'correct' => true],
                    ['text' => 'V = 0,7854 × d × L / 1.000', 'correct' => false],
                    ['text' => 'V = 3,14 × r² × L', 'correct' => false],
                    ['text' => 'V = (dp + du) / 2 × L', 'correct' => false],
                ],
            ],
            [
                'question' => 'Cacat "Pecah Banting" pada kayu bulat biasanya terjadi akibat...',
                'options' => [
                    ['text' => 'Serangan kumbang ambrosia', 'correct' => false],
                    ['text' => 'Benturan keras saat kegiatan penebangan atau penyaradan', 'correct' => true],
                    ['text' => 'Pengeringan yang terlalu cepat', 'correct' => false],
                    ['text' => 'Pertumbuhan pohon yang memuntir', 'correct' => false],
                ],
            ],
            [
                'question' => 'Berapa toleransi kelurusaan (kescylindrisan) untuk kayu bulat kualitas Pertama (P) pada umumnya?',
                'options' => [
                    ['text' => 'Maksimum 5%', 'correct' => false],
                    ['text' => 'Maksimum 2% untuk panjang < 2m', 'correct' => false],
                    ['text' => 'Tidak diperkenankan melengkung berlebihan (maksimal lengkung < 1,5% panjang)', 'correct' => true],
                    ['text' => 'Boleh lengkung asalkan diameter > 50cm', 'correct' => false],
                ],
            ],
            [
                'question' => 'Alat ukur yang wajib digunakan dan dikalibrasi untuk pengukuran diameter kayu bulat adalah...',
                'options' => [
                    ['text' => 'Meteran jahit', 'correct' => false],
                    ['text' => 'Pita ukur (Phiband) atau tongkat ukur (scale stick) standar kehutanan', 'correct' => true],
                    ['text' => 'Tali rafia', 'correct' => false],
                    ['text' => 'Jangka sorong digital', 'correct' => false],
                ],
            ],
            [
                'question' => 'Dalam pengujian cacat "Gubal Busuk" (GB), pengurangan volume dilakukan jika...',
                'options' => [
                    ['text' => 'Gubal busuk melingkar penuh pada bontos', 'correct' => true],
                    ['text' => 'Hanya terdapat pada satu sisi', 'correct' => false],
                    ['text' => 'Warnanya sedikit berubah', 'correct' => false],
                    ['text' => 'Kulit kayu terkelupas', 'correct' => false],
                ],
            ],
            [
                'question' => 'Istilah "Lengah" dalam cacat kayu bulat merujuk pada...',
                'options' => [
                    ['text' => 'Lubang gerekan serangga besar', 'correct' => false],
                    ['text' => 'Mata kayu yang busuk', 'correct' => false],
                    ['text' => 'Kondisi bontos yang tidak siku terhadap sumbu kayu', 'correct' => true],
                    ['text' => 'Retak halus di permukaan', 'correct' => false],
                ],
            ],
            [
                'question' => 'Untuk kayu Jati (Tectona grandis), pengukuran diameter untuk penetapan volume dilakukan dengan cara...',
                'options' => [
                    ['text' => 'Mengukur keliling sabuk (di tengah batang)', 'correct' => false],
                    ['text' => 'Rata-rata diameter pangkal dan diameter ujung tanpa kulit', 'correct' => true],
                    ['text' => 'Hanya diameter ujung saja', 'correct' => false],
                    ['text' => 'Hanya diameter pangkal saja', 'correct' => false],
                ],
            ],
            [
                'question' => 'Cacat "Mata Kayu Sehat" (MKS) pada kayu bulat dianggap menurunkan kualitas jika...',
                'options' => [
                    ['text' => 'Ukurannya kecil dan tersebar merata', 'correct' => false],
                    ['text' => 'Jumlahnya sangat banyak dan bergerombol (Whorl)', 'correct' => true],
                    ['text' => 'Warnanya sama dengan kayu sekitarnya', 'correct' => false],
                    ['text' => 'Posisinya berada di ujung bontos', 'correct' => false],
                ],
            ],
            [
                'question' => 'Simbol mutu untuk kayu bulat kualitas "Pertama" adalah...',
                'options' => [
                    ['text' => 'P', 'correct' => true],
                    ['text' => 'D', 'correct' => false],
                    ['text' => 'T', 'correct' => false],
                    ['text' => 'A', 'correct' => false],
                ],
            ],
            [
                'question' => 'Apa yang dimaksud dengan "Reduksi" dalam perhitungan volume kayu bulat?',
                'options' => [
                    ['text' => 'Potongan harga kayu', 'correct' => false],
                    ['text' => 'Pengurangan volume kotor akibat adanya cacat yang mengurangi isi pakai', 'correct' => true],
                    ['text' => 'Penyusutan kayu karena pengeringan', 'correct' => false],
                    ['text' => 'Pemotongan ujung kayu yang pecah', 'correct' => false],
                ],
            ],
            [
                'question' => 'Pajak atau pungutan negara yang dikenakan pada kayu bulat yang berasal dari hutan negara disebut...',
                'options' => [
                    ['text' => 'PPN (Pajak Pertambahan Nilai)', 'correct' => false],
                    ['text' => 'PSDH (Provisi Sumber Daya Hutan) dan DR (Dana Reboisasi)', 'correct' => true],
                    ['text' => 'PBB (Pajak Bumi dan Bangunan)', 'correct' => false],
                    ['text' => 'Retribusi Daerah', 'correct' => false],
                ],
            ],
            [
                'question' => 'Dokumen angkutan hasil hutan kayu yang sah saat ini dikenal dengan nama...',
                'options' => [
                    ['text' => 'SKSHH (Surat Keterangan Sahnya Hasil Hutan)', 'correct' => true],
                    ['text' => 'Faktur Pajak', 'correct' => false],
                    ['text' => 'Surat Jalan Polisi', 'correct' => false],
                    ['text' => 'Nota Angkutan', 'correct' => false],
                ],
            ],
            [
                'question' => 'Cacat "Gerowong" (Gr) diukur dengan cara...',
                'options' => [
                    ['text' => 'Mengukur kedalaman lubang', 'correct' => false],
                    ['text' => 'Mengukur diameter lubang gerowong terlebar dan terpendek, lalu dirata-rata', 'correct' => true],
                    ['text' => 'Menghitung jumlah semut di dalamnya', 'correct' => false],
                    ['text' => 'Mengukur volume air yang masuk', 'correct' => false],
                ],
            ],
            [
                'question' => 'Jenis kayu yang termasuk dalam kelompok kayu Indah I adalah...',
                'options' => [
                    ['text' => 'Sengon dan Akasia', 'correct' => false],
                    ['text' => 'Jati, Eboni, Sonokeling', 'correct' => true],
                    ['text' => 'Meranti dan Kapur', 'correct' => false],
                    ['text' => 'Glugu dan Karet', 'correct' => false],
                ],
            ],
            [
                'question' => 'Panjang kayu bulat diukur dalam satuan meter dengan pembulatan...',
                'options' => [
                    ['text' => '10 cm penuh ke bawah', 'correct' => true],
                    ['text' => '10 cm penuh ke atas', 'correct' => false],
                    ['text' => '1 cm terdekat', 'correct' => false],
                    ['text' => 'Tidak dibulatkan', 'correct' => false],
                ],
            ],
            [
                'question' => 'Cacat "Pecah Gelang" (Ring Shake) adalah...',
                'options' => [
                    ['text' => 'Pecah yang mengikuti lingkaran tumbuh (tahun) sebagian atau seluruhnya', 'correct' => true],
                    ['text' => 'Pecah yang memotong jari-jari kayu', 'correct' => false],
                    ['text' => 'Pecah pada bagian mata kayu', 'correct' => false],
                    ['text' => 'Pecah di permukaan luar saja', 'correct' => false],
                ],
            ],
            [
                'question' => 'Tugas utama seorang GanisPHPL-PKB adalah...',
                'options' => [
                    ['text' => 'Menanam pohon', 'correct' => false],
                    ['text' => 'Melakukan penebangan pohon', 'correct' => false],
                    ['text' => 'Melakukan pengukuran dan pengujian kayu bulat untuk penerbitan LHP (Laporan Hasil Produksi)', 'correct' => true],
                    ['text' => 'Menjual kayu ke konsumen', 'correct' => false],
                ],
            ],
            [
                'question' => 'Jika kayu memiliki panjang 4,68 meter, maka dalam Tally Sheet ditulis...',
                'options' => [
                    ['text' => '4,68 m', 'correct' => false],
                    ['text' => '4,70 m', 'correct' => false],
                    ['text' => '4,60 m', 'correct' => true],
                    ['text' => '5,00 m', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $q) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $q['question'],
                'type' => 'multiple_choice',
                'score' => 5, // 20 soal x 5 poin = 100
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
