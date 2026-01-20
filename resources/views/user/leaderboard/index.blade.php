@extends('layouts.user')

@section('title', 'Leaderboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-0"><i class="bi bi-trophy-fill text-warning me-2"></i>Leaderboard</h3>
                    <p class="text-muted mb-0">Peringkat peserta berdasarkan skor</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quiz Selection & Per-Quiz Leaderboard -->
        <div class="col-lg-8">
            <!-- Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="" method="GET" class="d-flex gap-3">
                        <select name="quiz_id" class="form-select" style="max-width: 350px;">
                            <option value="">-- Pilih Kuis --</option>
                            @foreach($quizzes as $quiz)
                                <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                    {{ $quiz->title }} ({{ $quiz->results_count }} peserta)
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                    </form>
                </div>
            </div>

            <!-- Per-Quiz Leaderboard -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        @if($selectedQuiz)
                            <i class="bi bi-trophy me-2"></i>{{ $selectedQuiz->title }}
                        @else
                            <i class="bi bi-trophy me-2"></i>Pilih Kuis
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(count($leaderboard) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80px;">Rank</th>
                                        <th>Peserta</th>
                                        <th>Skor</th>
                                        <th>Persentase</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaderboard as $item)
                                        <tr class="{{ $item['user']->id === auth()->id() ? 'table-primary' : '' }}">
                                            <td>
                                                @if($item['rank'] <= 3)
                                                    <span
                                                        class="badge rounded-pill {{ $item['rank'] == 1 ? 'bg-warning text-dark' : ($item['rank'] == 2 ? 'bg-secondary' : 'bg-danger') }}">
                                                        <i class="bi bi-trophy-fill me-1"></i>{{ $item['rank'] }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-light text-dark">{{ $item['rank'] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                        style="width: 36px; height: 36px; font-size: 0.8rem;">
                                                        {{ strtoupper(substr($item['user']->name, 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">
                                                            {{ $item['user']->name }}
                                                            @if($item['user']->id === auth()->id())
                                                                <span class="badge bg-info ms-1">Anda</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="h5 mb-0 fw-bold">{{ $item['score'] }}</span>
                                                <span class="text-muted small">poin</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $item['percentage'] >= 70 ? 'bg-success' : ($item['percentage'] >= 50 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                    {{ round($item['percentage']) }}%
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ gmdate('H:i:s', $item['completion_time']) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-trophy" style="font-size: 4rem; color: #64748b;"></i>
                            <p class="text-muted mt-3">
                                {{ $selectedQuiz ? 'Belum ada peserta' : 'Pilih kuis untuk melihat leaderboard' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Global Leaderboard -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-globe me-2"></i>Global Leaderboard</h5>
                </div>
                <div class="card-body p-0">
                    @if($globalLeaderboard->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($globalLeaderboard as $index => $item)
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-center {{ $item->user && $item->user->id === auth()->id() ? 'bg-light' : '' }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="fw-bold {{ $index < 3 ? 'text-warning' : 'text-muted' }}" style="width: 25px;">
                                            #{{ $index + 1 }}
                                        </span>
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px; font-size: 0.7rem;">
                                            {{ strtoupper(substr($item->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium small">
                                                {{ $item->user->name ?? 'Unknown' }}
                                                @if($item->user && $item->user->id === auth()->id())
                                                    <span class="badge bg-info ms-1">Anda</span>
                                                @endif
                                            </div>
                                            <div class="text-muted small">{{ $item->quiz_count }} kuis</div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold text-warning">{{ number_format($item->total_score) }}</div>
                                        <div class="text-muted small">{{ round($item->avg_percentage) }}% avg</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-bar-chart" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">Belum ada data</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Your Stats -->
            @php
                $myStats = \App\Models\Result::where('user_id', auth()->id())
                    ->whereNotNull('completed_at')
                    ->selectRaw('SUM(total_score) as total_score, COUNT(*) as quiz_count, AVG(percentage) as avg_percentage')
                    ->first();
            @endphp
            @if($myStats && $myStats->quiz_count > 0)
                <div class="card mt-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Statistik Anda</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="h4 mb-0 text-primary">{{ $myStats->quiz_count }}</div>
                                <small class="text-muted">Kuis</small>
                            </div>
                            <div class="col-4">
                                <div class="h4 mb-0 text-warning">{{ number_format($myStats->total_score) }}</div>
                                <small class="text-muted">Total Skor</small>
                            </div>
                            <div class="col-4">
                                <div class="h4 mb-0 text-success">{{ round($myStats->avg_percentage) }}%</div>
                                <small class="text-muted">Rata-rata</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection