@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="mb-0 opacity-75">Siap untuk tantangan baru hari ini? Jelajahi kuis yang tersedia dan
                        tingkatkan pengetahuan Anda.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="badge bg-light text-primary p-2">
                        <i class="bi bi-calendar-event me-1"></i> {{ now()->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Join Quiz Section -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(45deg, #6366f1 0%, #a855f7 100%);">
        <div class="card-body p-4 p-md-5 text-center text-white">
            <h2 class="fw-bold mb-3"><i class="bi bi-qr-code-scan me-2"></i>Punya Kode Kuis?</h2>
            <p class="fs-5 mb-4 opacity-90">Masukkan kode unik yang diberikan oleh instruktur Anda untuk memulai kuis.</p>

            <form action="{{ route('user.quizzes.join') }}" method="POST" class="row justify-content-center">
                @csrf
                <div class="col-md-6 col-lg-5">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-0 text-primary">
                            <i class="bi bi-key-fill"></i>
                        </span>
                        <input type="text" name="access_code" class="form-control border-0"
                            placeholder="Masukkan Kode Kuis (Contoh: QZ-12345)" required autocomplete="off"
                            style="box-shadow: none;">
                        <button class="btn btn-warning fw-bold px-4" type="submit">
                            GABUNG <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-journal-check text-primary fs-4"></i>
                    </div>
                    <h3 class="mb-1">{{ $totalQuizzesTaken }}</h3>
                    <small class="text-muted">Kuis Selesai</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="rounded-circle bg-success bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                    </div>
                    <h3 class="mb-1">{{ round($averageScore, 1) }}</h3>
                    <small class="text-muted">Rata-rata Skor</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="rounded-circle bg-info bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-check-circle text-info fs-4"></i>
                    </div>
                    <h3 class="mb-1">{{ $totalCorrectAnswers }}</h3>
                    <small class="text-muted">Jawaban Benar</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="rounded-circle bg-danger bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-x-circle text-danger fs-4"></i>
                    </div>
                    <h3 class="mb-1">{{ $totalWrongAnswers }}</h3>
                    <small class="text-muted">Jawaban Salah</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Results -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Terbaru</h5>
                    <a href="{{ route('user.results.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if($recentResults->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kuis</th>
                                        <th>Skor</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentResults as $result)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ Str::limit($result->quiz->title ?? 'Unknown', 30) }}</div>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $result->total_score }}</span>
                                                <span class="text-muted small">/ {{ $result->max_score ?? 100 }}</span>
                                            </td>
                                            <td>
                                                @if($result->is_passed)
                                                    <span class="badge bg-success">Lulus</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Lulus</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $result->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-journal-x" style="font-size: 3rem; color: #64748b;"></i>
                            <h6 class="mt-3 text-muted">Belum Ada Riwayat</h6>
                            <p class="text-muted small">Anda belum mengerjakan kuis apapun.</p>
                            <a href="{{ route('user.quizzes.index') }}" class="btn btn-primary">
                                <i class="bi bi-play-circle me-1"></i>Mulai Kuis
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('user.results.index') }}" class="btn btn-outline-success text-start py-3">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i>Lihat Riwayat
                        </a>
                        <a href="{{ route('user.leaderboard') }}" class="btn btn-outline-warning text-start py-3">
                            <i class="bi bi-trophy me-2"></i>Leaderboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary text-start py-3">
                            <i class="bi bi-person-gear me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection