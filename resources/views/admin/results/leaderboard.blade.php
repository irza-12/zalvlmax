@extends('layouts.admin')

@section('title', 'Leaderboard')
@section('page-title', 'Leaderboard: ' . ($quiz ? $quiz->title : 'Global'))

@section('content')
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="{{ route('admin.results.leaderboard') }}" method="GET" class="d-flex align-items-center">
                <select name="quiz_id" class="form-select w-auto me-2" onchange="this.form.submit()">
                    <option value="">-- Pilih Kuis --</option>
                    @foreach($quizzes as $q)
                        <option value="{{ $q->id }}" {{ $quiz && $quiz->id == $q->id ? 'selected' : '' }}>
                            {{ $q->title }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if($leaderboard->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="10%">Rank</th>
                                        <th>Peserta</th>
                                        <th>Total Skor</th>
                                        <th>Waktu</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaderboard as $index => $entry)
                                        <tr>
                                            <td>
                                                @if($index + 1 == 1)
                                                    <i class="bi bi-trophy-fill text-warning fs-4"></i>
                                                @elseif($index + 1 == 2)
                                                    <i class="bi bi-trophy-fill text-secondary fs-4"></i>
                                                @elseif($index + 1 == 3)
                                                    <i class="bi bi-trophy-fill text-danger fs-4"
                                                        style="color: #cd7f32 !important;"></i>
                                                @else
                                                    <span class="badge bg-light text-dark rounded-circle border p-2"
                                                        style="width: 30px; height: 30px;">
                                                        {{ $index + 1 }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $entry->user->name }}</div>
                                                <small class="text-muted">{{ $entry->user->email }}</small>
                                            </td>
                                            <td>
                                                <span class="fs-5 fw-bold text-primary">{{ floatval($entry->total_score) }}</span>
                                            </td>
                                            <td>{{ $entry->formatted_completion_time }}</td>
                                            <td>{{ $entry->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-bar-chart text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3 text-muted">Belum ada data leaderboard untuk kuis ini.</p>
                            <small>Pastikan user telah menyelesaikan kuis.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection