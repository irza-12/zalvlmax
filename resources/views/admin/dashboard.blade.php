@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Administrator')

@section('content')
    <div class="row mb-4">
        <!-- Statistics Cards -->
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Total Kuis</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalQuizzes }}</h2>
                    </div>
                    <i class="bi bi-journal-text" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Total Peserta</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalParticipants }}</h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Rata-rata Nilai</h6>
                        <h2 class="mb-0 fw-bold">{{ number_format($averageScore, 1) }}</h2>
                    </div>
                    <i class="bi bi-star" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Total Attempt</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalAttempts }}</h2>
                    </div>
                    <i class="bi bi-clipboard-check" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top Performers -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-trophy text-warning me-2"></i>Top Performers</h5>
                </div>
                <div class="card-body">
                    @if($topPerformers->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($topPerformers as $index => $performer)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-primary me-2">#{{ $index + 1 }}</span>
                                        <strong>{{ $performer->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $performer->quiz_count }} kuis selesai</small>
                                    </div>
                                    <span class="badge bg-success">{{ number_format($performer->total_score, 0) }} poin</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Results -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history text-info me-2"></i>Hasil Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentResults->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentResults as $result)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $result->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $result->quiz->title }}</small>
                                        </div>
                                        <span class="badge bg-{{ $result->total_score >= 70 ? 'success' : 'warning' }}">
                                            {{ number_format($result->total_score, 0) }}
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ $result->created_at->diffForHumans() }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart text-primary me-2"></i>Statistik Kuis</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul Kuis</th>
                                    <th>Status</th>
                                    <th>Jumlah Soal</th>
                                    <th>Peserta</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quizStats as $quiz)
                                    <tr>
                                        <td>{{ $quiz->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $quiz->status === 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($quiz->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $quiz->total_questions }}</td>
                                        <td>{{ $quiz->results_count }}</td>
                                        <td>
                                            <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada kuis</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection