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
        // ===== QUIZ 1: Chain of Custody (20 soal) =====
        $quiz1 = Quiz::updateOrCreate(
            ['title' => 'Evaluasi Pemahaman SOP Chain of Custody (CoC)'],
            [
                'description' => 'Kuis ini menguji pemahaman Anda tentang prinsip-prinsip Chain of Custody dalam pengelolaan kayu bersertifikat.',
                'duration' => 60,
                'start_time' => now(),
                'end_time' => now()->addDays(365),
                'status' => 'active',
            ]
        );

        $quiz1->questions()->delete();

        $cocQuestions = [
            ['q' => 'Tujuan utama penerapan Chain of Custody (CoC) adalah untuk:', 'options' => [['text' => 'Mempercepat proses penebangan kayu', 'correct' => false], ['text' => 'Menjamin keterlacakan, legalitas, dan keabsahan asal kayu', 'correct' => true], ['text' => 'Mengurangi biaya produksi kayu', 'correct' => false], ['text' => 'Menambah volume hasil hutan', 'correct' => false]]],
            ['q' => 'Ruang lingkup CoC mencakup proses pergerakan kayu mulai dari:', 'options' => [['text' => 'Gudang sampai pabrik', 'correct' => false], ['text' => 'Hutan alam ke pelabuhan', 'correct' => false], ['text' => 'Petak tebangan sampai mill gate', 'correct' => true], ['text' => 'TPK Antara ke industri', 'correct' => false]]],
            ['q' => 'Berikut ini yang bukan termasuk prinsip utama Chain of Custody adalah:', 'options' => [['text' => 'Penandaan', 'correct' => false], ['text' => 'Pemisahan', 'correct' => false], ['text' => 'Dokumentasi', 'correct' => false], ['text' => 'Produksi massal', 'correct' => true]]],
            ['q' => 'Yang dimaksud dengan Lacak Balak (Chain of Custody) adalah:', 'options' => [['text' => 'Sistem pengangkutan kayu berbasis volume', 'correct' => false], ['text' => 'Jalur pergerakan kayu dari petak tebangan sampai mill gate', 'correct' => true], ['text' => 'Proses pemanenan kayu di hutan tanaman', 'correct' => false], ['text' => 'Kegiatan penumpukan kayu di TPK', 'correct' => false]]],
            ['q' => 'PUHH adalah singkatan dari:', 'options' => [['text' => 'Pengukuran Umum Hasil Hutan', 'correct' => false], ['text' => 'Pengelolaan Usaha Hasil Hutan', 'correct' => false], ['text' => 'Penatausahaan Hasil Hutan', 'correct' => true], ['text' => 'Pengawasan Usaha Hutan', 'correct' => false]]],
            ['q' => 'Sistem informasi berbasis web yang digunakan untuk pencatatan dan pelaporan hasil hutan adalah:', 'options' => [['text' => 'SIMPONI', 'correct' => false], ['text' => 'SIPNBP', 'correct' => false], ['text' => 'SIPUHH', 'correct' => true], ['text' => 'WOTS', 'correct' => false]]],
            ['q' => 'Tempat pengumpulan kayu hasil pemanenan di sekitar petak tebangan disebut:', 'options' => [['text' => 'TPK Antara', 'correct' => false], ['text' => 'TPK Hutan', 'correct' => false], ['text' => 'TPn', 'correct' => true], ['text' => 'Mill Gate', 'correct' => false]]],
            ['q' => 'Simpul terakhir dalam alur pergerakan kayu adalah:', 'options' => [['text' => 'TPn', 'correct' => false], ['text' => 'TPK Antara', 'correct' => false], ['text' => 'Pos Faktur', 'correct' => false], ['text' => 'Mill Gate', 'correct' => true]]],
            ['q' => 'Dokumen yang memuat data hasil penebangan berdasarkan buku ukur disebut:', 'options' => [['text' => 'BCP', 'correct' => false], ['text' => 'SKSHHK', 'correct' => false], ['text' => 'LHP', 'correct' => true], ['text' => 'SPK', 'correct' => false]]],
            ['q' => 'Label tumpukan kayu dipasang setelah kegiatan:', 'options' => [['text' => 'Penebangan', 'correct' => false], ['text' => 'Penyaradan', 'correct' => false], ['text' => 'Pengukuran tumpukan', 'correct' => true], ['text' => 'Pengangkutan', 'correct' => false]]],
            ['q' => 'Warna label tumpukan kayu yang digunakan dalam CoC adalah:', 'options' => [['text' => 'Merah', 'correct' => false], ['text' => 'Hijau', 'correct' => false], ['text' => 'Biru', 'correct' => false], ['text' => 'Kuning', 'correct' => true]]],
            ['q' => 'Kayu yang telah di-LHP-kan dan PSDH-nya sudah dibayar ditandai dengan:', 'options' => [['text' => 'Stempel merah', 'correct' => false], ['text' => 'Tanda centang (√)', 'correct' => true], ['text' => 'Kode barcode', 'correct' => false], ['text' => 'Nomor seri tambahan', 'correct' => false]]],
            ['q' => 'SPK Trip In digunakan untuk pengangkutan kayu dari:', 'options' => [['text' => 'Pos faktur ke mill', 'correct' => false], ['text' => 'TPn/tempat transit ke pos faktur', 'correct' => true], ['text' => 'TPK Antara ke industri', 'correct' => false], ['text' => 'TPn ke tempat transit', 'correct' => false]]],
            ['q' => 'Dokumen resmi angkutan hasil hutan kayu yang diterbitkan melalui SIPUHH adalah:', 'options' => [['text' => 'SPK', 'correct' => false], ['text' => 'SPA Lansir', 'correct' => false], ['text' => 'SKSHHK', 'correct' => true], ['text' => 'BKMK', 'correct' => false]]],
            ['q' => 'Buku yang mencatat keluar masuknya kayu sebagai dasar neraca kayu disebut:', 'options' => [['text' => 'BCP', 'correct' => false], ['text' => 'BKMK', 'correct' => true], ['text' => 'LHP', 'correct' => false], ['text' => 'RKT', 'correct' => false]]],
            ['q' => 'Kayu yang identitasnya tidak diketahui dan tidak dapat ditelusuri disebut:', 'options' => [['text' => 'Kayu HTI', 'correct' => false], ['text' => 'Kayu Non-HTI', 'correct' => false], ['text' => 'Uncontrolled Wood', 'correct' => true], ['text' => 'Kayu Sertifikat', 'correct' => false]]],
            ['q' => 'Kayu IFCC-PEFC harus:', 'options' => [['text' => 'Dicampur dengan kayu non sertifikat', 'correct' => false], ['text' => 'Disimpan tanpa dokumen', 'correct' => false], ['text' => 'Dipisahkan secara fisik dan dokumen', 'correct' => true], ['text' => 'Tidak perlu label', 'correct' => false]]],
            ['q' => 'Aplikasi internal perusahaan untuk mendukung aktivitas CoC adalah:', 'options' => [['text' => 'SIPUHH', 'correct' => false], ['text' => 'SIMPONI', 'correct' => false], ['text' => 'WOTS (Wood Tracking System)', 'correct' => true], ['text' => 'SIPNBP', 'correct' => false]]],
            ['q' => 'Pihak yang bertanggung jawab menunjuk dan menetapkan penanggung jawab CoC adalah:', 'options' => [['text' => 'Koordinator CoC Distrik', 'correct' => false], ['text' => 'Tim Juru Ukur', 'correct' => false], ['text' => 'Kepala PBPH', 'correct' => true], ['text' => 'Petugas Pos Faktur', 'correct' => false]]],
            ['q' => 'Semua dokumen CoC wajib disimpan minimal selama:', 'options' => [['text' => '1 tahun', 'correct' => false], ['text' => '3 tahun', 'correct' => false], ['text' => '5 tahun', 'correct' => true], ['text' => '10 tahun', 'correct' => false]]],
        ];

        foreach ($cocQuestions as $q) {
            $question = Question::create([
                'quiz_id' => $quiz1->id,
                'question_text' => $q['q'],
                'type' => 'multiple_choice',
                'score' => 5,
            ]);
            foreach ($q['options'] as $opt) {
                $question->options()->create(['option_text' => $opt['text'], 'is_correct' => $opt['correct']]);
            }
        }

        // ===== QUIZ 2: Tes Kemampuan Umum Tingkat Tinggi (40 soal) =====
        $quiz2 = Quiz::updateOrCreate(
            ['title' => 'Tes Kemampuan Umum Tingkat Tinggi (Non-Matematika)'],
            [
                'description' => 'Tes komprehensif untuk mengukur pengetahuan umum tingkat tinggi mencakup aspek nasional dan internasional dalam bidang sejarah, geografi, politik, ekonomi, sains, teknologi, budaya, dan isu global.',
                'duration' => 90,
                'start_time' => now(),
                'end_time' => now()->addDays(365),
                'status' => 'active',
            ]
        );

        $quiz2->questions()->delete();

        $advancedQuestions = [
            // SEJARAH NASIONAL (5 soal)
            ['q' => 'Perjanjian Linggarjati (1947) mengakui kedaulatan de facto Republik Indonesia atas wilayah:', 'options' => [['text' => 'Seluruh kepulauan Nusantara', 'correct' => false], ['text' => 'Jawa, Sumatera, dan Madura', 'correct' => true], ['text' => 'Jawa dan Bali', 'correct' => false], ['text' => 'Sumatera dan Kalimantan', 'correct' => false]]],
            ['q' => 'Dekrit Presiden 5 Juli 1959 dikeluarkan oleh Presiden Soekarno dengan tujuan utama:', 'options' => [['text' => 'Membubarkan partai politik', 'correct' => false], ['text' => 'Kembali ke UUD 1945 dan membubarkan Konstituante', 'correct' => true], ['text' => 'Mengganti sistem ekonomi', 'correct' => false], ['text' => 'Mengumumkan Dwikora', 'correct' => false]]],
            ['q' => 'Gerakan 30 September 1965 (G30S) berujung pada pengangkatan Jenderal Soeharto melalui:', 'options' => [['text' => 'Pemilu 1966', 'correct' => false], ['text' => 'Supersemar (Surat Perintah Sebelas Maret)', 'correct' => true], ['text' => 'Dekrit Presiden', 'correct' => false], ['text' => 'Sidang MPR Khusus', 'correct' => false]]],
            ['q' => 'Reformasi 1998 di Indonesia dipicu oleh krisis ekonomi yang bermula dari:', 'options' => [['text' => 'Krisis minyak dunia', 'correct' => false], ['text' => 'Krisis finansial Asia 1997', 'correct' => true], ['text' => 'Perang Teluk', 'correct' => false], ['text' => 'Embargo ekonomi PBB', 'correct' => false]]],
            ['q' => 'Konferensi Asia-Afrika 1955 di Bandung menghasilkan prinsip-prinsip yang dikenal sebagai:', 'options' => [['text' => 'Piagam PBB', 'correct' => false], ['text' => 'Dasasila Bandung', 'correct' => true], ['text' => 'Deklarasi HAM Universal', 'correct' => false], ['text' => 'Traktat Non-Proliferasi', 'correct' => false]]],

            // SEJARAH INTERNASIONAL (5 soal)
            ['q' => 'Revolusi Industri yang dimulai di Inggris pada abad ke-18 ditandai dengan penemuan:', 'options' => [['text' => 'Komputer', 'correct' => false], ['text' => 'Mesin uap', 'correct' => true], ['text' => 'Listrik', 'correct' => false], ['text' => 'Telepon', 'correct' => false]]],
            ['q' => 'Perang Dingin (Cold War) berlangsung antara dua blok kekuatan utama yaitu:', 'options' => [['text' => 'Amerika Serikat vs China', 'correct' => false], ['text' => 'Amerika Serikat vs Uni Soviet', 'correct' => true], ['text' => 'Inggris vs Jerman', 'correct' => false], ['text' => 'Perancis vs Jepang', 'correct' => false]]],
            ['q' => 'Perjanjian Westphalia (1648) dianggap sebagai awal dari sistem:', 'options' => [['text' => 'Demokrasi modern', 'correct' => false], ['text' => 'Negara-bangsa (nation-state) modern', 'correct' => true], ['text' => 'Kapitalisme global', 'correct' => false], ['text' => 'Imperialisme Eropa', 'correct' => false]]],
            ['q' => 'Nelson Mandela menjadi presiden kulit hitam pertama di Afrika Selatan setelah berakhirnya:', 'options' => [['text' => 'Kolonialisme Belanda', 'correct' => false], ['text' => 'Apartheid', 'correct' => true], ['text' => 'Perang Saudara', 'correct' => false], ['text' => 'Pendudukan Inggris', 'correct' => false]]],
            ['q' => 'Tembok Berlin yang memisahkan Jerman Barat dan Timur runtuh pada tahun:', 'options' => [['text' => '1985', 'correct' => false], ['text' => '1989', 'correct' => true], ['text' => '1991', 'correct' => false], ['text' => '1995', 'correct' => false]]],

            // GEOGRAFI DAN LINGKUNGAN (5 soal)
            ['q' => 'Ring of Fire (Cincin Api Pasifik) adalah zona dengan aktivitas vulkanik dan gempa bumi tinggi yang melintasi:', 'options' => [['text' => 'Samudra Atlantik', 'correct' => false], ['text' => 'Samudra Pasifik', 'correct' => true], ['text' => 'Samudra Hindia', 'correct' => false], ['text' => 'Laut Mediterania', 'correct' => false]]],
            ['q' => 'Indonesia merupakan negara kepulauan terbesar di dunia dengan jumlah pulau sekitar:', 'options' => [['text' => '5.000 pulau', 'correct' => false], ['text' => '17.000 pulau', 'correct' => true], ['text' => '25.000 pulau', 'correct' => false], ['text' => '10.000 pulau', 'correct' => false]]],
            ['q' => 'Protokol Kyoto (1997) adalah perjanjian internasional yang bertujuan untuk:', 'options' => [['text' => 'Menghentikan perang nuklir', 'correct' => false], ['text' => 'Mengurangi emisi gas rumah kaca', 'correct' => true], ['text' => 'Melindungi hak asasi manusia', 'correct' => false], ['text' => 'Mengatur perdagangan internasional', 'correct' => false]]],
            ['q' => 'Hutan Amazon, yang disebut "paru-paru dunia", terletak di benua:', 'options' => [['text' => 'Afrika', 'correct' => false], ['text' => 'Amerika Selatan', 'correct' => true], ['text' => 'Asia Tenggara', 'correct' => false], ['text' => 'Australia', 'correct' => false]]],
            ['q' => 'Fenomena El Niño menyebabkan perubahan iklim yang ditandai dengan:', 'options' => [['text' => 'Peningkatan curah hujan di Indonesia', 'correct' => false], ['text' => 'Kekeringan di Indonesia dan banjir di Amerika', 'correct' => true], ['text' => 'Suhu dingin ekstrem global', 'correct' => false], ['text' => 'Peningkatan es di Kutub', 'correct' => false]]],

            // POLITIK DAN HUKUM (5 soal)
            ['q' => 'Organisasi internasional yang berwenang mengeluarkan resolusi mengikat secara hukum adalah:', 'options' => [['text' => 'Majelis Umum PBB', 'correct' => false], ['text' => 'Dewan Keamanan PBB', 'correct' => true], ['text' => 'UNESCO', 'correct' => false], ['text' => 'WHO', 'correct' => false]]],
            ['q' => 'Sistem pemerintahan Indonesia berdasarkan UUD 1945 hasil amandemen adalah:', 'options' => [['text' => 'Parlementer', 'correct' => false], ['text' => 'Presidensial', 'correct' => true], ['text' => 'Semi-presidensial', 'correct' => false], ['text' => 'Monarki konstitusional', 'correct' => false]]],
            ['q' => 'Mahkamah Internasional (ICJ) berkedudukan di kota:', 'options' => [['text' => 'New York', 'correct' => false], ['text' => 'Den Haag', 'correct' => true], ['text' => 'Jenewa', 'correct' => false], ['text' => 'Brussel', 'correct' => false]]],
            ['q' => 'Dalam sistem demokrasi, separation of powers membagi kekuasaan menjadi tiga cabang yaitu:', 'options' => [['text' => 'Legislatif, Eksekutif, dan Yudikatif', 'correct' => true], ['text' => 'Militer, Sipil, dan Legislatif', 'correct' => false], ['text' => 'Federal, Negara Bagian, dan Lokal', 'correct' => false], ['text' => 'Pusat, Daerah, dan Desa', 'correct' => false]]],
            ['q' => 'ASEAN didirikan pada tahun 1967 melalui Deklarasi Bangkok oleh lima negara pendiri, kecuali:', 'options' => [['text' => 'Indonesia', 'correct' => false], ['text' => 'Filipina', 'correct' => false], ['text' => 'Vietnam', 'correct' => true], ['text' => 'Thailand', 'correct' => false]]],

            // EKONOMI (5 soal)
            ['q' => 'Produk Domestik Bruto (PDB) mengukur:', 'options' => [['text' => 'Jumlah uang beredar di masyarakat', 'correct' => false], ['text' => 'Total nilai barang dan jasa yang diproduksi dalam suatu negara', 'correct' => true], ['text' => 'Tingkat pengangguran nasional', 'correct' => false], ['text' => 'Jumlah ekspor dikurangi impor', 'correct' => false]]],
            ['q' => 'Bank sentral Indonesia (Bank Indonesia) memiliki tugas utama:', 'options' => [['text' => 'Menyalurkan kredit ke masyarakat', 'correct' => false], ['text' => 'Menjaga stabilitas nilai rupiah', 'correct' => true], ['text' => 'Mengumpulkan pajak', 'correct' => false], ['text' => 'Mengatur perdagangan internasional', 'correct' => false]]],
            ['q' => 'Organisasi perdagangan dunia yang mengatur aturan perdagangan antar negara adalah:', 'options' => [['text' => 'IMF', 'correct' => false], ['text' => 'WTO', 'correct' => true], ['text' => 'World Bank', 'correct' => false], ['text' => 'OECD', 'correct' => false]]],
            ['q' => 'Inflasi adalah kondisi ekonomi yang ditandai dengan:', 'options' => [['text' => 'Turunnya harga barang secara umum', 'correct' => false], ['text' => 'Naiknya harga barang secara umum dan terus-menerus', 'correct' => true], ['text' => 'Meningkatnya nilai mata uang', 'correct' => false], ['text' => 'Berkurangnya utang negara', 'correct' => false]]],
            ['q' => 'G20 adalah forum ekonomi internasional yang beranggotakan:', 'options' => [['text' => '20 negara termakmur di dunia', 'correct' => false], ['text' => '19 negara dan Uni Eropa', 'correct' => true], ['text' => '20 negara Asia-Pasifik', 'correct' => false], ['text' => '20 negara dengan populasi terbesar', 'correct' => false]]],

            // SAINS DAN TEKNOLOGI (5 soal)
            ['q' => 'CRISPR-Cas9 adalah teknologi revolusioner dalam bidang:', 'options' => [['text' => 'Kecerdasan buatan', 'correct' => false], ['text' => 'Penyuntingan gen (gene editing)', 'correct' => true], ['text' => 'Energi nuklir', 'correct' => false], ['text' => 'Eksplorasi luar angkasa', 'correct' => false]]],
            ['q' => 'Internet pertama kali dikembangkan oleh departemen pertahanan AS dengan nama:', 'options' => [['text' => 'WorldWideWeb', 'correct' => false], ['text' => 'ARPANET', 'correct' => true], ['text' => 'Ethernet', 'correct' => false], ['text' => 'TCP/IP', 'correct' => false]]],
            ['q' => 'Vaksin mRNA yang digunakan untuk COVID-19 bekerja dengan cara:', 'options' => [['text' => 'Menyuntikkan virus yang dilemahkan', 'correct' => false], ['text' => 'Menginstruksikan sel untuk memproduksi protein spike', 'correct' => true], ['text' => 'Membunuh virus langsung dalam tubuh', 'correct' => false], ['text' => 'Meningkatkan suhu tubuh untuk membunuh virus', 'correct' => false]]],
            ['q' => 'Teori Relativitas yang dikemukakan oleh Albert Einstein menjelaskan hubungan antara:', 'options' => [['text' => 'Atom dan molekul', 'correct' => false], ['text' => 'Ruang, waktu, dan gravitasi', 'correct' => true], ['text' => 'Listrik dan magnet', 'correct' => false], ['text' => 'Panas dan energi', 'correct' => false]]],
            ['q' => 'Artificial Intelligence (AI) generatif seperti ChatGPT menggunakan arsitektur:', 'options' => [['text' => 'Blockchain', 'correct' => false], ['text' => 'Transformer', 'correct' => true], ['text' => 'Quantum computing', 'correct' => false], ['text' => 'Neural network tradisional', 'correct' => false]]],

            // BUDAYA DAN SOSIAL (5 soal)
            ['q' => 'UNESCO mencatat warisan budaya tak benda Indonesia yang diakui dunia, termasuk:', 'options' => [['text' => 'Tari Samba', 'correct' => false], ['text' => 'Batik', 'correct' => true], ['text' => 'Origami', 'correct' => false], ['text' => 'Flamenco', 'correct' => false]]],
            ['q' => 'Sustainable Development Goals (SDGs) yang diadopsi PBB tahun 2015 terdiri dari:', 'options' => [['text' => '8 tujuan', 'correct' => false], ['text' => '17 tujuan', 'correct' => true], ['text' => '25 tujuan', 'correct' => false], ['text' => '12 tujuan', 'correct' => false]]],
            ['q' => 'Bonus demografi Indonesia diproyeksikan terjadi pada periode:', 'options' => [['text' => '2010-2020', 'correct' => false], ['text' => '2020-2035', 'correct' => true], ['text' => '2040-2050', 'correct' => false], ['text' => '2000-2010', 'correct' => false]]],
            ['q' => 'Gerakan #MeToo yang viral secara global bertujuan untuk:', 'options' => [['text' => 'Mempromosikan pendidikan perempuan', 'correct' => false], ['text' => 'Melawan pelecehan dan kekerasan seksual', 'correct' => true], ['text' => 'Meningkatkan partisipasi politik perempuan', 'correct' => false], ['text' => 'Memperjuangkan kesetaraan upah', 'correct' => false]]],
            ['q' => 'Istilah "post-truth" yang menjadi Word of the Year 2016 oleh Oxford Dictionary merujuk pada:', 'options' => [['text' => 'Era setelah penemuan internet', 'correct' => false], ['text' => 'Kondisi di mana emosi lebih berpengaruh daripada fakta', 'correct' => true], ['text' => 'Zaman setelah Perang Dingin', 'correct' => false], ['text' => 'Periode pasca-modernisme', 'correct' => false]]],

            // ISU GLOBAL KONTEMPORER (5 soal)
            ['q' => 'Paris Agreement (2015) adalah kesepakatan global untuk membatasi kenaikan suhu bumi maksimal:', 'options' => [['text' => '0.5°C di atas tingkat pra-industri', 'correct' => false], ['text' => '1.5-2°C di atas tingkat pra-industri', 'correct' => true], ['text' => '3°C di atas tingkat pra-industri', 'correct' => false], ['text' => '5°C di atas tingkat pra-industri', 'correct' => false]]],
            ['q' => 'Belt and Road Initiative (BRI) adalah mega-proyek infrastruktur yang digagas oleh:', 'options' => [['text' => 'Amerika Serikat', 'correct' => false], ['text' => 'China', 'correct' => true], ['text' => 'Uni Eropa', 'correct' => false], ['text' => 'Jepang', 'correct' => false]]],
            ['q' => 'Cryptocurrency seperti Bitcoin menggunakan teknologi dasar yang disebut:', 'options' => [['text' => 'Cloud computing', 'correct' => false], ['text' => 'Blockchain', 'correct' => true], ['text' => 'Machine learning', 'correct' => false], ['text' => 'Quantum computing', 'correct' => false]]],
            ['q' => 'Pandemi COVID-19 dinyatakan oleh WHO sebagai pandemi global pada bulan:', 'options' => [['text' => 'Januari 2020', 'correct' => false], ['text' => 'Maret 2020', 'correct' => true], ['text' => 'Juni 2020', 'correct' => false], ['text' => 'Desember 2019', 'correct' => false]]],
            ['q' => 'BRICS adalah kelompok negara ekonomi berkembang yang terdiri dari Brasil, Rusia, India, China, dan:', 'options' => [['text' => 'Singapura', 'correct' => false], ['text' => 'Afrika Selatan', 'correct' => true], ['text' => 'Saudi Arabia', 'correct' => false], ['text' => 'Turki', 'correct' => false]]],
        ];

        foreach ($advancedQuestions as $q) {
            $question = Question::create([
                'quiz_id' => $quiz2->id,
                'question_text' => $q['q'],
                'type' => 'multiple_choice',
                'score' => 2.5, // 2.5 poin x 40 soal = 100
            ]);
            foreach ($q['options'] as $opt) {
                $question->options()->create(['option_text' => $opt['text'], 'is_correct' => $opt['correct']]);
            }
        }
    }
}
