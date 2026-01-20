<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HighLevelGeneralQuizSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Quiz Baru
        $quiz = Quiz::create([
            'title' => 'Tes Potensi Akademik (High Level)',
            'description' => 'Tes kemampuan umum tingkat lanjut yang mencakup kemampuan verbal, numerik, dan penalaran logis. Terdiri dari 20 soal dengan tingkat kesulitan tinggi.',
            'duration' => 30, // 30 menit
            'passing_score' => 75,
            'max_attempts' => 0, // Unlimited
            'status' => 'active',
            'access_type' => 'public',
            'access_password' => null,
            'created_by' => 1, // Superadmin
        ]);

        $quizId = $quiz->id;

        // Daftar Soal
        $questions = [
            // VERBAL (1-5)
            [
                'question_text' => 'EPISODE : SERIAL = ... : ...',
                'options' => [
                    ['text' => 'Bait : Puisi', 'is_correct' => true],
                    ['text' => 'Halaman : Buku', 'is_correct' => false],
                    ['text' => 'Adegan : Aktor', 'is_correct' => false],
                    ['text' => 'Bab : Novel', 'is_correct' => false],
                    ['text' => 'Lagu : Album', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Pilihlah kata yang TIDAK sekelompok dengan lainnya:',
                'options' => [
                    ['text' => 'Borobudur', 'is_correct' => false],
                    ['text' => 'Prambanan', 'is_correct' => false],
                    ['text' => 'Mendut', 'is_correct' => false],
                    ['text' => 'Muara Takus', 'is_correct' => false],
                    ['text' => 'Besakih', 'is_correct' => true], // Pura (Hindu Bali), lainnya Candi Buddha/Hindu Jawa/Sumatera
                ],
            ],
            [
                'question_text' => 'INSOMNIA : TIDUR = ... : ...',
                'options' => [
                    ['text' => 'Lumpuh : Jalan', 'is_correct' => true], // Ketidakmampuan : Aktivitas
                    ['text' => 'Makan : Kenyang', 'is_correct' => false],
                    ['text' => 'Sedih : Menangis', 'is_correct' => false],
                    ['text' => 'Sakit : Obat', 'is_correct' => false],
                    ['text' => 'Haus : Minum', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Sinonim dari kata "EKLEKTIK" adalah:',
                'options' => [
                    ['text' => 'Memilih yang terbaik dari berbagai sumber', 'is_correct' => true],
                    ['text' => 'Sangat eksklusif dan terbatas', 'is_correct' => false],
                    ['text' => 'Menolak ide-ide baru', 'is_correct' => false],
                    ['text' => 'Kuno dan tradisional', 'is_correct' => false],
                    ['text' => 'Sederhana dan apa adanya', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Antonim dari kata "NISBI" adalah:',
                'options' => [
                    ['text' => 'Mutlak', 'is_correct' => true],
                    ['text' => 'Relatif', 'is_correct' => false],
                    ['text' => 'Maya', 'is_correct' => false],
                    ['text' => 'Abstrak', 'is_correct' => false],
                    ['text' => 'Bergantung', 'is_correct' => false],
                ],
            ],

            // NUMERIK & KUANTITATIF (6-10)
            [
                'question_text' => 'Lanjutkan deret angka berikut: 4, 6, 9, 14, 21, ...',
                'options' => [
                    ['text' => '30', 'is_correct' => false],
                    ['text' => '32', 'is_correct' => true],
                    ['text' => '28', 'is_correct' => false],
                    ['text' => '35', 'is_correct' => false],
                    ['text' => '29', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Jika x = 1/16 dan y = 16%, manakah pernyataan yang benar?',
                'options' => [
                    ['text' => 'x > y', 'is_correct' => false],
                    ['text' => 'x < y', 'is_correct' => true],
                    ['text' => 'x = y', 'is_correct' => false],
                    ['text' => 'x dan y tidak bisa ditentukan', 'is_correct' => false],
                    ['text' => 'x = 2y', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Sebuah baju didiskon dua kali berturut-turut yaitu 20% dan kemudian 10%. Berapa total diskon efektif yang diberikan?',
                'options' => [
                    ['text' => '30%', 'is_correct' => false],
                    ['text' => '28%', 'is_correct' => true],
                    ['text' => '25%', 'is_correct' => false],
                    ['text' => '32%', 'is_correct' => false],
                    ['text' => '18%', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Jika 3x + 5y = 21 dan 2x - y = -12, berapakah nilai x + y?',
                'options' => [
                    ['text' => '3', 'is_correct' => true],
                    ['text' => '-3', 'is_correct' => false],
                    ['text' => '9', 'is_correct' => false],
                    ['text' => '5', 'is_correct' => false],
                    ['text' => '0', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Data: 3, 5, 7, x, 10, 10, 12. Jika rata-rata data tersebut adalah 8, berapakah nilai median-nya?',
                'options' => [
                    ['text' => '8', 'is_correct' => false],
                    ['text' => '9', 'is_correct' => true],
                    ['text' => '10', 'is_correct' => false],
                    ['text' => '7', 'is_correct' => false],
                    ['text' => '8.5', 'is_correct' => false],
                ],
            ],

            // LOGIKA & PENALARAN (11-15)
            [
                'question_text' => 'Semua dokter adalah profesional. Sebagian profesional adalah orang kaya. Kesimpulannya adalah...',
                'options' => [
                    ['text' => 'Semua dokter adalah orang kaya', 'is_correct' => false],
                    ['text' => 'Sebagian dokter adalah orang kaya', 'is_correct' => false],
                    ['text' => 'Sebagian orang kaya adalah dokter', 'is_correct' => false],
                    ['text' => 'Semua orang kaya adalah profesional', 'is_correct' => false],
                    ['text' => 'Tidak dapat ditarik kesimpulan pasti', 'is_correct' => true],
                ],
            ],
            [
                'question_text' => 'Jika hujan, maka jalanan basah. Jalanan tidak basah. Kesimpulannya?',
                'options' => [
                    ['text' => 'Tidak hujan', 'is_correct' => true],
                    ['text' => 'Hujan turun rintik-rintik', 'is_correct' => false],
                    ['text' => 'Jalanan kering karena panas', 'is_correct' => false],
                    ['text' => 'Mendung tapi tidak hujan', 'is_correct' => false],
                    ['text' => 'Tidak ada kesimpulan', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Semua anggota asosiasi profesi harus hadir dalam rapat. Sebagian dokter adalah anggota asosiasi. Kesimpulannya?',
                'options' => [
                    ['text' => 'Semua dokter harus hadir dalam rapat', 'is_correct' => false],
                    ['text' => 'Sebagian dokter harus hadir dalam rapat', 'is_correct' => true],
                    ['text' => 'Semua peserta rapat adalah dokter', 'is_correct' => false],
                    ['text' => 'Sebagian yang hadir rapat bukan dokter', 'is_correct' => false],
                    ['text' => 'Tidak ada kesimpulan valid', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'A lebih berat dari B. C lebih ringan dari B. D lebih berat dari B tapi lebih ringan dari A. Siapakah yang paling berat?',
                'options' => [
                    ['text' => 'A', 'is_correct' => true],
                    ['text' => 'B', 'is_correct' => false],
                    ['text' => 'C', 'is_correct' => false],
                    ['text' => 'D', 'is_correct' => false],
                    ['text' => 'A dan D sama berat', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Negasi dari pernyataan "Semua siswa lulus ujian" adalah...',
                'options' => [
                    ['text' => 'Semua siswa tidak lulus ujian', 'is_correct' => false],
                    ['text' => 'Tidak ada siswa yang lulus ujian', 'is_correct' => false],
                    ['text' => 'Ada siswa yang tidak lulus ujian', 'is_correct' => true],
                    ['text' => 'Beberapa siswa lulus ujian', 'is_correct' => false],
                    ['text' => 'Siswa rajin belajar', 'is_correct' => false],
                ],
            ],

            // PENGETAHUAN UMUM & ANALISIS (16-20)
            [
                'question_text' => 'Ibukota negara Kazakhstan yang baru (sejak 2019, kemudian kembali ke nama lama di 2022) sering menjadi topik trivia. Apa ibukota Kazakhstan saat ini?',
                'options' => [
                    ['text' => 'Almaty', 'is_correct' => false],
                    ['text' => 'Astana', 'is_correct' => true],
                    ['text' => 'Tashkent', 'is_correct' => false],
                    ['text' => 'Bishkek', 'is_correct' => false],
                    ['text' => 'Dushanbe', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Manakah di bawah ini yang BUKAN merupakan gas rumah kaca utama?',
                'options' => [
                    ['text' => 'Karbon Dioksida (CO2)', 'is_correct' => false],
                    ['text' => 'Metana (CH4)', 'is_correct' => false],
                    ['text' => 'Nitrogen (N2)', 'is_correct' => true],
                    ['text' => 'Uap Air (H2O)', 'is_correct' => false],
                    ['text' => 'Ozon (O3)', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Dalam teori ekonomi, situasi di mana hanya ada satu penjual yang menguasai pasar disebut...',
                'options' => [
                    ['text' => 'Monopsoni', 'is_correct' => false],
                    ['text' => 'Oligopoli', 'is_correct' => false],
                    ['text' => 'Monopoli', 'is_correct' => true],
                    ['text' => 'Pasar Persaingan Sempurna', 'is_correct' => false],
                    ['text' => 'Oligopsoni', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Siapakah penulis novel "Siti Nurbaya" yang sangat ikonik dalam sastra Indonesia?',
                'options' => [
                    ['text' => 'Marah Rusli', 'is_correct' => true],
                    ['text' => 'Abdul Muis', 'is_correct' => false],
                    ['text' => 'Sutan Takdir Alisjahbana', 'is_correct' => false],
                    ['text' => 'Chairil Anwar', 'is_correct' => false],
                    ['text' => 'Pramoedya Ananta Toer', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Apa nama selat yang memisahkan Pulau Jawa dan Pulau Bali?',
                'options' => [
                    ['text' => 'Selat Sunda', 'is_correct' => false],
                    ['text' => 'Selat Madura', 'is_correct' => false],
                    ['text' => 'Selat Lombok', 'is_correct' => false],
                    ['text' => 'Selat Bali', 'is_correct' => true],
                    ['text' => 'Selat Makassar', 'is_correct' => false],
                ],
            ]
        ];

        foreach ($questions as $q) {
            $question = Question::create([
                'quiz_id' => $quizId,
                'question_text' => $q['question_text'],
                'type' => 'multiple_choice',
            ]);

            foreach ($q['options'] as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'],
                    'is_correct' => $opt['is_correct'],
                ]);
            }
        }
    }
}
