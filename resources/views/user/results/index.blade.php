@extends('layouts.user')

@section('title', 'Riwayat Kuis')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-white mb-3">
                <i class="bi bi-clock-history me-2"></i>Riwayat Kuis
            </h2>
        </div>
    </div>

    <div class="row">
        @forelse($results as $result)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span
                                class="badge bg-{{ $result->total_score >= 80 ? 'success' : ($result->total_score >= 60 ? 'warning' : 'danger') }}">
                                Skor: {{ floatval($result->total_score) }}
                            </span>
                            <small class="text-muted">{{ $result->created_at->format('d M Y, H:i') }}</small>
                        </div>

                        <h5 class="card-title">{{ $result->quiz->title }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($result->quiz->description, 80) }}</p>

                        <div class="row text-center mt-3 g-2">
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <span class="d-block text-success fw-bold">{{ $result->correct_answers }}</span>
                                    <small style="font-size: 0.7rem">Benar</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <span class="d-block text-danger fw-bold">{{ $result->wrong_answers }}</span>
                                    <small style="font-size: 0.7rem">Salah</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <span class="d-block text-primary fw-bold">{{ $result->percentage }}%</span>
                                    <small style="font-size: 0.7rem">Akurasi</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="{{ route('user.results.show', $result) }}" class="btn btn-primary btn-sm flex-fill me-2">
                            <i class="bi bi-eye me-1"></i>Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 text-muted">Belum ada riwayat kuis</h5>
                        <p class="text-muted">Ayo mulai kerjakan kuis sekarang!</p>
                        <a href="{{ route('user.quizzes.index') }}" class="btn btn-primary mt-2">
                            Lihat Daftar Kuis
                        </a>
                    </div>
                </div>
            </div>
        @endforelse

        <div class="mt-3">
            {{ $results->links() }}
        </div>
    </div>
@endsection