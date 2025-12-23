@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h2 class="text-gray-800 fw-bold mb-1">
                Selamat Datang, {{ auth()->user()->name }}!
            </h2>
            <p class="text-muted">Berikut adalah ringkasan aktivitas kuis Anda.</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Card 1 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 text-uppercase small fw-bold">Kuis Dikerjakan</p>
                            <h2 class="mb-0 fw-bold text-gray-800">{{ $totalQuizzesTaken }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-journal-check text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 text-uppercase small fw-bold">Rata-rata Nilai</p>
                            <h2 class="mb-0 fw-bold text-gray-800">{{ number_format($averageScore, 1) }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-star-fill text-success fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 text-uppercase small fw-bold">Jawaban Benar</p>
                            <h2 class="mb-0 fw-bold text-gray-800">{{ $totalCorrectAnswers }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-check-circle-fill text-info fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 text-uppercase small fw-bold">Jawaban Salah</p>
                            <h2 class="mb-0 fw-bold text-gray-800">{{ $totalWrongAnswers }}</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-x-circle-fill text-danger fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Results -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history text-primary me-2"></i>Hasil Terbaru</h5>
                        <a href="{{ route('user.results.index') }}"
                            class="btn btn-sm btn-light text-primary fw-medium">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentResults->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentResults as $result)
                                <a href="{{ route('user.results.show', $result) }}"
                                    class="list-group-item list-group-item-action py-3 px-4 border-light">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">{{ $result->quiz->title }}</h6>
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-calendar-event me-1"></i>{{ $result->created_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="badge bg-{{ $result->total_score >= 70 ? 'success' : ($result->total_score >= 50 ? 'warning' : 'danger') }} rounded-pill px-3 py-2">
                                                    {{ number_format($result->total_score, 0) }}
                                                </span>
                                                <i class="bi bi-chevron-right text-muted ms-3"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                <i class="bi bi-clipboard-data text-muted fs-1"></i>
                            </div>
                            <h6 class="text-muted">Belum ada riwayat kuis</h6>
                            <a href="{{ route('user.quizzes.index') }}" class="btn btn-primary mt-2">
                                Mulai Kuis Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge text-warning me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('user.quizzes.index') }}"
                            class="btn btn-primary btn-lg text-start p-3 d-flex align-items-center shadow-sm">
                            <div class="bg-white bg-opacity-25 rounded p-2 me-3">
                                <i class="bi bi-play-fill fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Mulai Kuis</div>
                                <small class="text-white-50" style="font-size: 0.8rem;">Kerjakan kuis yang tersedia</small>
                            </div>
                        </a>

                        <a href="{{ route('user.leaderboard') }}"
                            class="btn btn-warning btn-lg text-start p-3 text-white d-flex align-items-center shadow-sm">
                            <div class="bg-white bg-opacity-25 rounded p-2 me-3">
                                <i class="bi bi-trophy-fill fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Leaderboard</div>
                                <small class="text-white-50" style="font-size: 0.8rem;">Lihat peringkat global</small>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="btn btn-info btn-lg text-start p-3 text-white d-flex align-items-center shadow-sm">
                            <div class="bg-white bg-opacity-25 rounded p-2 me-3">
                                <i class="bi bi-person-fill fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Profile Saya</div>
                                <small class="text-white-50" style="font-size: 0.8rem;">Update data diri</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quote -->
            <div class="card border-0 shadow-sm bg-dark text-white overflow-hidden position-relative">
                <div class="position-absolute top-0 end-0 opacity-10 p-3">
                    <i class="bi bi-quote fs-1"></i>
                </div>
                <div class="card-body p-4 position-relative">
                    <figure class="mb-0">
                        <blockquote class="blockquote">
                            <p class="fs-6 mb-3">"Pendidikan adalah senjata paling ampuh untuk mengubah dunia."</p>
                        </blockquote>
                        <figcaption class="blockquote-footer text-white-50 mb-0">
                            Nelson Mandela
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </div>
@endsection