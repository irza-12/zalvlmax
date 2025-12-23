@extends('layouts.user')

@section('title', 'Daftar Kuis')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h2 class="text-gray-800 fw-bold mb-1">
                <i class="bi bi-journal-text me-2 text-primary"></i>Kuis Tersedia
            </h2>
            <p class="text-muted">Pilih kuis yang ingin Anda kerjakan.</p>
        </div>
    </div>

    <!-- Active Quizzes -->
    @if($activeQuizzes->count() > 0)
        <div class="row mb-4">
            <div class="col-12 mb-3">
                <h5 class="text-dark fw-bold border-bottom pb-2">
                    <i class="bi bi-play-circle-fill me-2 text-success"></i>Kuis Aktif
                </h5>
            </div>
            @foreach($activeQuizzes as $quiz)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 rounded-pill">
                                    <i class="bi bi-circle-fill me-1 small"></i>Aktif
                                </span>
                                <span class="badge bg-light text-dark border px-3 rounded-pill">
                                    <i class="bi bi-clock me-1"></i>{{ $quiz->duration }}m
                                </span>
                            </div>

                            <h5 class="card-title fw-bold text-dark mb-2">{{ $quiz->title }}</h5>
                            <p class="card-text text-muted small mb-4">{{ Str::limit($quiz->description, 100) }}</p>

                            <div
                                class="d-flex justify-content-between align-items-center small text-muted bg-light p-3 rounded mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-list-task me-2 fs-5"></i>
                                    <div style="line-height:1.2">
                                        <div class="fw-bold">{{ $quiz->questions_count }}</div>
                                        <div style="font-size:0.75rem">Soal</div>
                                    </div>
                                </div>
                                <div class="vr mx-2"></div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-star me-2 fs-5"></i>
                                    <div style="line-height:1.2">
                                        <div class="fw-bold">{{ $quiz->total_score }}</div>
                                        <div style="font-size:0.75rem">Poin</div>
                                    </div>
                                </div>
                            </div>

                            <div class="small text-muted mb-1">
                                <i class="bi bi-calendar-event me-2"></i>Deadline:
                            </div>
                            <div class="small fw-bold text-dark">
                                {{ $quiz->end_time->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 p-3 pt-0">
                            <a href="{{ route('user.quizzes.show', $quiz) }}" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                                <i class="bi bi-play-fill me-1"></i>Mulai Kuis
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                            <i class="bi bi-inbox text-muted fs-1"></i>
                        </div>
                        <h5 class="mt-3 text-dark fw-bold">Tidak ada kuis aktif saat ini</h5>
                        <p class="text-muted">Silakan cek kembali secara berkala</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Upcoming Quizzes -->
    @if($upcomingQuizzes->count() > 0)
        <div class="row mb-5">
            <div class="col-12 mb-3">
                <h5 class="text-dark fw-bold border-bottom pb-2">
                    <i class="bi bi-calendar-event me-2 text-warning"></i>Akan Datang
                </h5>
            </div>
            @foreach($upcomingQuizzes as $quiz)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm opacity-75">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 rounded-pill">
                                    <i class="bi bi-hourglass-split me-1"></i>Soon
                                </span>
                                <span class="badge bg-light text-dark border px-3 rounded-pill">
                                    {{ $quiz->duration }}m
                                </span>
                            </div>

                            <h5 class="card-title fw-bold text-dark">{{ $quiz->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($quiz->description, 80) }}</p>

                            <div class="alert alert-light border small mb-0 mt-3">
                                <i class="bi bi-calendar-check me-2"></i>Mulai:
                                <strong>{{ $quiz->start_time->format('d M Y, H:i') }}</strong>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 p-3 pt-0">
                            <button class="btn btn-light text-muted w-100 border" disabled>
                                <i class="bi bi-lock-fill me-2"></i>Belum Dimulai
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm border-start border-info border-4">
                <div class="card-body bg-light">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle-fill text-info me-2"></i>Informasi
                        Penting</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="mb-0 text-muted small ps-3">
                                <li class="mb-2">Pastikan koneksi internet stabil sebelum memulai.</li>
                                <li class="mb-2">Waktu akan berjalan mundur otomatis.</li>
                                <li class="mb-2">Jawaban tersimpan otomatis per soal.</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="mb-0 text-muted small ps-3">
                                <li class="mb-2">Dilarang refresh halaman secara berlebihan.</li>
                                <li class="mb-2">Hasil langsung keluar setelah selesai.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .hover-shadow:hover {
                transform: translateY(-5px);
                box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
                transition: all 0.3s ease;
            }

            .transition-all {
                transition: all 0.3s ease;
            }
        </style>
    @endpush
@endsection