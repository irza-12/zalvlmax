@extends('layouts.user')

@section('title', 'Hasil Kuis')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Result Header -->
            <div class="card mb-4 text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        @if($result->total_score >= 80)
                            <i class="bi bi-trophy-fill text-warning" style="font-size: 5rem;"></i>
                            <h3 class="mt-3 text-success">Luar Biasa!</h3>
                        @elseif($result->total_score >= 60)
                            <i class="bi bi-star-fill text-primary" style="font-size: 5rem;"></i>
                            <h3 class="mt-3 text-primary">Bagus!</h3>
                        @else
                            <i class="bi bi-emoji-smile text-warning" style="font-size: 5rem;"></i>
                            <h3 class="mt-3 text-warning">Tetap Semangat!</h3>
                        @endif
                    </div>

                    <h2 class="display-4 fw-bold mb-2">{{ number_format($result->total_score, 0) }}</h2>
                    <p class="text-muted mb-4">Total Skor Anda</p>

                    <div class="row text-center">
                        <div class="col-4">
                            <div class="p-3">
                                <h4 class="text-success mb-1">{{ $result->correct_answers }}</h4>
                                <small class="text-muted">Benar</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3">
                                <h4 class="text-danger mb-1">{{ $result->wrong_answers }}</h4>
                                <small class="text-muted">Salah</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3">
                                <h4 class="text-primary mb-1">{{ $result->percentage }}%</h4>
                                <small class="text-muted">Persentase</small>
                            </div>
                        </div>
                    </div>

                    @if($result->completion_time)
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                Waktu Pengerjaan: <strong>{{ $result->formatted_completion_time }}</strong>
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quiz Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5><i class="bi bi-journal-text me-2"></i>{{ $result->quiz->title }}</h5>
                    <p class="text-muted mb-0">{{ $result->quiz->description }}</p>
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>
                        Dikerjakan pada: {{ $result->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>



            <!-- Actions -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
                            <i class="bi bi-house me-2"></i>Kembali ke Dashboard
                        </a>
                        <a href="{{ route('user.quizzes.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-journal-text me-2"></i>Kuis Lainnya
                        </a>
                        <a href="{{ route('user.leaderboard', $result->quiz) }}" class="btn btn-primary">
                            <i class="bi bi-trophy me-2"></i>Lihat Leaderboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection