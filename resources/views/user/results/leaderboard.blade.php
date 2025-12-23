@extends('layouts.user')

@section('title', 'Leaderboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="text-white mb-3">
            <i class="bi bi-trophy me-2"></i>Leaderboard
        </h2>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('user.leaderboard') }}" method="GET" class="d-flex align-items-center mb-0">
            <label class="me-2 fw-bold">Pilih Kuis:</label>
            <select name="quiz_id" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">-- Global Rank --</option>
                @foreach($quizzes as $q)
                    <option value="{{ $q->id }}" {{ $quiz && $quiz->id == $q->id ? 'selected' : '' }}>
                        {{ $q->title }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($leaderboard->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">Rank</th>
                            <th>Peserta</th>
                            <th>Skor</th>
                            <th>Waktu Pengerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaderboard as $index => $entry)
                            <tr class="{{ Auth::id() == $entry->user_id ? 'table-warning border-start border-warning border-4' : '' }}">
                                <td>
                                    @if($index + 1 == 1)
                                        <div class="rank-badge rank-1 shadow-sm"><i class="bi bi-trophy-fill text-dark me-0"></i></div>
                                    @elseif($index + 1 == 2)
                                        <div class="rank-badge rank-2 shadow-sm"><i class="bi bi-trophy-fill text-dark me-0"></i></div>
                                    @elseif($index + 1 == 3)
                                        <div class="rank-badge rank-3 shadow-sm"><i class="bi bi-trophy-fill text-dark me-0"></i></div>
                                    @else
                                        <div class="rank-badge bg-light border fw-bold text-muted" style="width: 40px; height: 40px; font-size: 1rem;">
                                            {{ $index + 1 }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold {{ Auth::id() == $entry->user_id ? 'text-primary' : '' }}">
                                        {{ $entry->user->name }}
                                        @if(Auth::id() == $entry->user_id)
                                            <span class="badge bg-primary ms-2">Anda</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <h5 class="mb-0 fw-bold text-success">{{ floatval($entry->total_score) }}</h5>
                                </td>
                                <td class="text-muted">
                                    <i class="bi bi-stopwatch me-1"></i>{{ $entry->formatted_completion_time }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-trophy text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                <p class="mt-3 text-muted">Belum ada data untuk leaderboard ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
