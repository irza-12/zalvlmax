@extends('layouts.user')

@section('title', 'Mengerjakan Kuis')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Quiz Header -->
        <!-- Quiz Header (Sticky Timer) -->
        <div class="card mb-4 border-0 shadow-sm sticky-top" style="z-index: 1020; top: 1rem;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-none d-md-block">
                        <h6 class="mb-0 fw-bold text-dark">{{ $quiz->title }}</h6>
                        <small class="text-muted">
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-list-ol me-1"></i>Soal {{ $quiz->questions()->where('id', '<=', $question->id)->count() }} / {{ $quiz->questions_count }}
                            </span>
                        </small>
                    </div>
                    <!-- Mobile view for Title (hidden) or simplified -->
                    <div class="d-md-none">
                        <span class="badge bg-light text-dark border">
                            {{ $quiz->questions()->where('id', '<=', $question->id)->count() }} / {{ $quiz->questions_count }}
                        </span>
                    </div>

                    <div class="text-end d-flex align-items-center">
                        <div class="me-2 text-end d-none d-sm-block">
                            <small class="text-muted d-block" style="font-size: 0.7rem; line-height: 1;">Sisa Waktu</small>
                        </div>
                        <div id="timer" class="fs-4 fw-bold text-primary font-monospace bg-primary bg-opacity-10 px-3 py-1 rounded">
                            <i class="bi bi-stopwatch me-2"></i><span id="time-display">--:--</span>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                @if(isset($progress))
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" 
                         style="width: {{ $progress['percentage'] }}%;" 
                         aria-valuenow="{{ $progress['percentage'] }}" 
                         aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Question Card -->
        <div class="card">
            <div class="card-body p-4">
                <div class="mb-4">
                    <span class="badge bg-primary mb-3">
                        {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                    </span>
                    <span class="badge bg-success mb-3 ms-2">
                        <i class="bi bi-star me-1"></i>{{ $question->score }} Poin
                    </span>
                    <h4 class="mt-2">{{ $question->question_text }}</h4>
                </div>

                <form action="{{ route('user.quizzes.submit-answer', [$quiz, $question]) }}" method="POST" id="answerForm">
                    @csrf
                    
                    <div class="options-container">
                        @foreach($question->options as $index => $option)
                            <div class="form-check option-item p-3 mb-3 border rounded" 
                                 style="cursor: pointer; transition: all 0.3s;"
                                 onclick="selectOption(this, {{ $option->id }})">
                                <input class="form-check-input" 
                                       type="{{ $question->type === 'multiple_correct' ? 'checkbox' : 'radio' }}" 
                                       name="option_id" 
                                       id="option{{ $option->id }}" 
                                       value="{{ $option->id }}"
                                       {{ isset($userAnswer) && $userAnswer->option_id == $option->id ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label w-100" for="option{{ $option->id }}" style="cursor: pointer;">
                                    <strong>{{ chr(65 + $index) }}.</strong> {{ $option->option_text }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    @error('option_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="d-flex justify-content-between mt-4">
                        @if($quiz->questions()->where('id', '<', $question->id)->exists())
                            <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
                                <i class="bi bi-arrow-left me-2"></i>Sebelumnya
                            </button>
                        @else
                            <div></div>
                        @endif

                        {{-- Tombol submit hanya muncul jika tipe soal BUKAN multiple choice / true false, atau jika ini soal essay/checkbox --}}
                        @if($question->type === 'multiple_correct' || $question->type === 'essay')
                            <button type="submit" class="btn btn-primary btn-lg">
                                @if($quiz->questions()->where('id', '>', $question->id)->exists())
                                    Selanjutnya <i class="bi bi-arrow-right ms-2"></i>
                                @else
                                    Selesai <i class="bi bi-check-circle ms-2"></i>
                                @endif
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Card -->
        <div class="card mt-3 bg-light">
            <div class="card-body">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>Tips:</strong> Pilih jawaban yang menurut Anda paling tepat. 
                    @if($question->type === 'multiple_correct')
                        Soal ini bisa memiliki lebih dari satu jawaban benar.
                    @else
                        Jawaban akan otomatis tersimpan dan lanjut ke soal berikutnya saat diklik.
                    @endif
                </small>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.option-item:hover {
    background-color: #f8f9fa;
    border-color: #6366f1 !important;
    transform: translateX(5px);
}

.option-item.selected {
    background-color: #e0e7ff;
    border-color: #6366f1 !important;
}

.form-check-input:checked ~ .form-check-label {
    color: #6366f1;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
// Timer functionality
let duration = {{ $remainingSeconds }}; // From Controller logic
const timerDisplay = document.getElementById('time-display');
const answerForm = document.getElementById('answerForm');

function updateTimer() {
    const minutes = Math.floor(duration / 60);
    const seconds = Math.floor(duration % 60);
    timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    
    if (duration <= 0) {
        clearInterval(timerInterval);
        alert('Waktu habis! Kuis akan otomatis diselesaikan.');
        window.location.href = '{{ route("user.quizzes.finish", $quiz) }}';
    }
    
    // Warning when 5 minutes left
    if (duration === 300) {
        // Optional warning
    }
    
    // Warning when 1 minute left
    if (duration === 60) {
        timerDisplay.classList.add('text-danger');
    }
    
    duration--;
}

const timerInterval = setInterval(updateTimer, 1000);
// Initial call
updateTimer(); 

// Option selection
function selectOption(element, optionId) {
    const radio = element.querySelector('input[type="radio"]');
    const checkbox = element.querySelector('input[type="checkbox"]');
    
    if (radio) {
        // Remove selected class from all options
        document.querySelectorAll('.option-item').forEach(item => {
            item.classList.remove('selected');
        });
        
        // Add selected class to clicked option
        element.classList.add('selected');
        radio.checked = true;

        // AUTO SUBMIT FOR RADIO BUTTONS
        answerForm.submit();

    } else if (checkbox) {
        // Toggle selected class
        element.classList.toggle('selected');
        checkbox.checked = !checkbox.checked;
    }
}

// Auto-submit on time up part 2 (load handling)
window.addEventListener('load', function() {
    // Mark selected option on page load
    const checkedInput = document.querySelector('input[name="option_id"]:checked');
    if (checkedInput) {
        checkedInput.closest('.option-item').classList.add('selected');
    }
});
</script>
@endpush
@endsection
