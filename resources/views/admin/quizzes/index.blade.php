@extends('layouts.admin')

@section('title', 'Kelola Kuis')
@section('page-title', 'Kelola Kuis')

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Kuis Baru
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Durasi</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th>Soal</th>
                            <th>Peserta</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quizzes as $index => $quiz)
                            <tr>
                                <td>{{ $quizzes->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $quiz->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($quiz->description, 50) }}</small>
                                </td>
                                <td>{{ $quiz->duration }} menit</td>
                                <td>
                                    <small>
                                        {{ $quiz->start_time->format('d/m/Y H:i') }}
                                        <br>
                                        s/d {{ $quiz->end_time->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <form action="{{ route('admin.quizzes.toggle-status', $quiz) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="badge bg-{{ $quiz->status === 'active' ? 'success' : 'secondary' }} border-0">
                                            {{ ucfirst($quiz->status) }}
                                        </button>
                                    </form>
                                </td>
                                <td>{{ $quiz->questions_count }}</td>
                                <td>{{ $quiz->results_count }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-sm btn-info"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.questions.index', $quiz) }}" class="btn btn-sm btn-primary"
                                            title="Kelola Soal">
                                            <i class="bi bi-list-check"></i>
                                        </a>
                                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kuis ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada kuis. <a href="{{ route('admin.quizzes.create') }}">Tambah kuis baru</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($quizzes->hasPages())
                <div class="mt-3">
                    {{ $quizzes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection