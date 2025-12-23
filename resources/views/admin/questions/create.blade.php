@extends('layouts.admin')

@section('title', 'Tambah Soal')
@section('page-title', 'Tambah Soal - ' . $quiz->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.questions.store', $quiz) }}" method="POST" id="questionForm">
                    @csrf

                    <div class="mb-3">
                        <label for="question_text" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('question_text') is-invalid @enderror" 
                                  id="question_text" name="question_text" rows="3" required>{{ old('question_text') }}</textarea>
                        @error('question_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipe Soal <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="multiple_choice" {{ old('type') == 'multiple_choice' ? 'selected' : '' }}>Pilihan Ganda</option>
                                <option value="true_false" {{ old('type') == 'true_false' ? 'selected' : '' }}>Benar/Salah</option>
                                <option value="multiple_correct" {{ old('type') == 'multiple_correct' ? 'selected' : '' }}>Multiple Correct</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="score" class="form-label">Bobot Nilai <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('score') is-invalid @enderror" 
                                   id="score" name="score" value="{{ old('score', 10) }}" min="1" required>
                            @error('score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Opsi Jawaban <span class="text-danger">*</span></label>
                        <div id="optionsContainer">
                            @for($i = 0; $i < 4; $i++)
                                <div class="option-row mb-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="correct_options[]" value="{{ $i }}" 
                                                   {{ is_array(old('correct_options')) && in_array($i, old('correct_options')) ? 'checked' : '' }}>
                                        </div>
                                        <input type="text" class="form-control" name="options[]" 
                                               placeholder="Opsi {{ chr(65 + $i) }}" 
                                               value="{{ old('options.' . $i) }}" required>
                                        @if($i >= 2)
                                            <button type="button" class="btn btn-danger" onclick="removeOption(this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addOption()">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Opsi
                        </button>
                        @error('options')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('correct_options')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>Centang checkbox untuk menandai jawaban yang benar
                        </small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.questions.index', $quiz) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-journal-text me-2"></i>Info Kuis</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $quiz->title }}</strong></p>
                <p class="small text-muted mb-2">{{ $quiz->description }}</p>
                <hr>
                <p class="small mb-1">Durasi: <strong>{{ $quiz->duration }} menit</strong></p>
                <p class="small mb-1">Status: <span class="badge bg-{{ $quiz->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($quiz->status) }}</span></p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Panduan</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2"><strong>Tipe Soal:</strong></p>
                <ul class="small text-muted">
                    <li><strong>Pilihan Ganda:</strong> Hanya 1 jawaban benar</li>
                    <li><strong>Benar/Salah:</strong> 2 opsi (Benar/Salah)</li>
                    <li><strong>Multiple Correct:</strong> Bisa lebih dari 1 jawaban benar</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let optionIndex = 4;

function addOption() {
    const container = document.getElementById('optionsContainer');
    const optionRow = document.createElement('div');
    optionRow.className = 'option-row mb-2';
    optionRow.innerHTML = `
        <div class="input-group">
            <div class="input-group-text">
                <input type="checkbox" name="correct_options[]" value="${optionIndex}">
            </div>
            <input type="text" class="form-control" name="options[]" 
                   placeholder="Opsi ${String.fromCharCode(65 + optionIndex)}" required>
            <button type="button" class="btn btn-danger" onclick="removeOption(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(optionRow);
    optionIndex++;
}

function removeOption(button) {
    const optionRow = button.closest('.option-row');
    optionRow.remove();
    updateOptionIndexes();
}

function updateOptionIndexes() {
    const options = document.querySelectorAll('.option-row');
    options.forEach((option, index) => {
        const checkbox = option.querySelector('input[type="checkbox"]');
        const input = option.querySelector('input[type="text"]');
        checkbox.value = index;
        input.placeholder = `Opsi ${String.fromCharCode(65 + index)}`;
    });
    optionIndex = options.length;
}

// Handle type change for True/False
document.getElementById('type').addEventListener('change', function() {
    if (this.value === 'true_false') {
        const container = document.getElementById('optionsContainer');
        container.innerHTML = `
            <div class="option-row mb-2">
                <div class="input-group">
                    <div class="input-group-text">
                        <input type="checkbox" name="correct_options[]" value="0">
                    </div>
                    <input type="text" class="form-control" name="options[]" value="Benar" readonly>
                </div>
            </div>
            <div class="option-row mb-2">
                <div class="input-group">
                    <div class="input-group-text">
                        <input type="checkbox" name="correct_options[]" value="1">
                    </div>
                    <input type="text" class="form-control" name="options[]" value="Salah" readonly>
                </div>
            </div>
        `;
        optionIndex = 2;
    }
});
</script>
@endpush
@endsection
