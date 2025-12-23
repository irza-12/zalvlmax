@extends('layouts.admin')

@section('title', 'Detail Kuis')
@section('page-title', 'Detail Kuis')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <!-- Quiz Details -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Kuis</h5>
                    <div>
                        <span class="badge bg-{{ $quiz->status === 'active' ? 'success' : 'secondary' }} me-2">
                            {{ ucfirst($quiz->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="mb-3">{{ $quiz->title }}</h3>
                    <p class="text-muted">{{ $quiz->description }}</p>

                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block uppercase">Durasi</small>
                            <strong>{{ $quiz->duration }} Menit</strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block uppercase">Mulai</small>
                            <strong>{{ $quiz->start_time->format('d M Y H:i') }}</strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block uppercase">Selesai</small>
                            <strong>{{ $quiz->end_time->format('d M Y H:i') }}</strong>
                        </div>
                    </div>

                    <div class="d-flex mt-3 gap-2">
                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>Edit Kuis
                        </a>
                        <a href="{{ route('admin.questions.index', $quiz) }}" class="btn btn-primary">
                            <i class="bi bi-list-check me-2"></i>Kelola Soal
                        </a>
                        <a href="{{ route('admin.results.leaderboard', $quiz) }}" class="btn btn-info text-white">
                            <i class="bi bi-trophy me-2"></i>Leaderboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Questions Preview -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Soal (Preview)</h5>
                    <a href="{{ route('admin.questions.index', $quiz) }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($quiz->questions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Pertanyaan</th>
                                        <th width="15%">Tipe</th>
                                        <th width="10%">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quiz->questions->take(5) as $index => $question)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ Str::limit($question->question_text, 80) }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                                </span>
                                            </td>
                                            <td>{{ $question->score }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($quiz->questions->count() > 5)
                            <div class="text-center mt-3">
                                <small class="text-muted">Menampilkan 5 dari {{ $quiz->questions->count() }} soal</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard-x text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">Belum ada soal ditambahkan.</p>
                            <a href="{{ route('admin.questions.create', $quiz) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Tambah Soal
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Statistik Kuis</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Soal</span>
                        <span class="fw-bold fs-5">{{ $quiz->questions_count }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Poin</span>
                        <span class="fw-bold fs-5 text-success">{{ $quiz->questions->sum('score') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Peserta Selesai</span>
                        <span class="fw-bold fs-5 text-primary">{{ $quiz->results->count() }}</span>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a href="{{ route('admin.results.index', ['quiz_id' => $quiz->id]) }}"
                            class="btn btn-outline-primary w-100">
                            <i class="bi bi-eye me-2"></i>Lihat Hasil Peserta
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.quizzes.toggle-status', $quiz) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit"
                            class="btn btn-{{ $quiz->status === 'active' ? 'outline-secondary' : 'success' }} w-100">
                            @if($quiz->status === 'active')
                                <i class="bi bi-pause-circle me-2"></i>Nonaktifkan Kuis
                            @else
                                <i class="bi bi-play-circle me-2"></i>Aktifkan Kuis
                            @endif
                        </button>
                    </form>

                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuis ini? Semua data soal dan hasil peserta akan ikut terhapus!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Hapus Kuis
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection