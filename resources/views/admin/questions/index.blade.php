@extends('layouts.admin')

@section('title', 'Kelola Soal')
@section('page-title', 'Kelola Soal: ' . $quiz->title)

@section('content')
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Kuis
                </a>
                <span class="text-muted">Total: {{ $questions->total() }} Soal</span>
            </div>
            <a href="{{ route('admin.questions.create', $quiz) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Soal Baru
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @forelse($questions as $index => $question)
                <div class="card mb-3 border border-light shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge bg-primary me-2">No. {{ $questions->firstItem() + $index }}</span>
                            <span class="badge bg-info text-dark">{{ ucfirst(str_replace('_', ' ', $question->type)) }}</span>
                            <span class="badge bg-success ms-1">{{ $question->score }} Poin</span>
                        </div>
                        <div>
                            <a href="{{ route('admin.questions.edit', [$quiz, $question]) }}"
                                class="btn btn-sm btn-warning text-white me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.questions.destroy', [$quiz, $question]) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Yakin hapus soal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text fs-5 mb-3">{{ $question->question_text }}</p>

                        <div class="row">
                            @foreach($question->options as $option)
                                <div class="col-md-6 mb-2">
                                    <div
                                        class="p-2 border rounded {{ $option->is_correct ? 'bg-success bg-opacity-10 border-success' : 'bg-light' }}">
                                        @if($option->is_correct)
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        @else
                                            <i class="bi bi-circle text-muted me-2"></i>
                                        @endif
                                        {{ $option->option_text }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-clipboard-x text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">Belum ada soal</h5>
                        <p class="text-muted">Silakan tambahkan soal pertama untuk kuis ini.</p>
                    </div>
                </div>
            @endforelse

            <div class="mt-3">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
@endsection