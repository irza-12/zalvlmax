@extends('layouts.user')

@section('title', $quiz->title)

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Quiz Header Card -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-success fs-6">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Kuis Aktif
                        </span>
                        <span class="badge bg-primary fs-6">
                            <i class="bi bi-clock me-1"></i>{{ $quiz->duration }} Menit
                        </span>
                    </div>

                    <h2 class="mb-3">{{ $quiz->title }}</h2>
                    <p class="text-muted lead">{{ $quiz->description }}</p>

                    <hr class="my-4">

                    <!-- Quiz Info -->
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="p-3">
                                <i class="bi bi-list-check text-primary" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-0">{{ $quiz->total_questions }}</h4>
                                <small class="text-muted">Soal</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="p-3">
                                <i class="bi bi-star text-warning" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-0">{{ $quiz->total_score }}</h4>
                                <small class="text-muted">Total Poin</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="p-3">
                                <i class="bi bi-clock text-info" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-0">{{ $quiz->duration }}</h4>
                                <small class="text-muted">Menit</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="p-3">
                                <i class="bi bi-calendar-check text-success" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-0">
                                    {{ $quiz->end_time ? $quiz->end_time->format('d M') : '∞' }}
                                </h4>
                                <small class="text-muted">Deadline</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions Card -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Instruksi</h5>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <li class="mb-2">Kuis ini terdiri dari <strong>{{ $quiz->total_questions }} soal</strong> dengan
                            total poin <strong>{{ $quiz->total_score }}</strong></li>
                        <li class="mb-2">Waktu pengerjaan: <strong>{{ $quiz->duration }} menit</strong></li>
                        <li class="mb-2">Timer akan mulai berjalan saat Anda klik tombol "Mulai Kuis"</li>
                        <li class="mb-2">Jawaban akan otomatis tersimpan setiap kali Anda menjawab</li>
                        <li class="mb-2">Anda hanya bisa mengerjakan kuis ini <strong>satu kali</strong></li>
                        <li class="mb-2">Pastikan koneksi internet stabil selama mengerjakan</li>
                        <li class="mb-2">Hasil akan langsung ditampilkan setelah Anda menyelesaikan kuis</li>
                    </ol>
                </div>
            </div>

            <!-- Question Types Info -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Tipe Soal</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3 border rounded">
                                <i class="bi bi-ui-radios text-primary" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Pilihan Ganda</h6>
                                <small class="text-muted">Pilih 1 jawaban yang benar</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3 border rounded">
                                <i class="bi bi-check2-square text-success" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Benar/Salah</h6>
                                <small class="text-muted">Pilih Benar atau Salah</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3 border rounded">
                                <i class="bi bi-ui-checks text-warning" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Multiple Correct</h6>
                                <small class="text-muted">Bisa lebih dari 1 jawaban</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ready to Start -->
            <div class="card bg-primary text-white text-center py-4">
                <div class="card-body text-center py-5">
                    <h3 class="mb-3">Siap Memulai?</h3>
                    <p class="mb-4">Pastikan Anda sudah membaca semua instruksi di atas</p>

                    <a href="{{ route('user.quizzes.start', $quiz) }}" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-play-circle-fill me-2"></i>Mulai Kuis Sekarang
                    </a>

                    <div class="mt-3">
                        <a href="{{ route('user.quizzes.index') }}" class="text-white text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Kuis
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card mt-4 bg-light">
                <div class="card-body">
                    <h6><i class="bi bi-lightbulb text-warning me-2"></i>Tips Sukses</h6>
                    <ul class="small mb-0">
                        <li>Baca setiap pertanyaan dengan teliti</li>
                        <li>Manajemen waktu dengan baik - rata-rata {{ round($quiz->duration / $quiz->total_questions, 1) }}
                            menit per soal</li>
                        <li>Jangan panik jika ada soal yang sulit, lanjutkan ke soal berikutnya</li>
                        <li>Periksa kembali jawaban Anda jika masih ada waktu</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection