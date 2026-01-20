@extends('layouts.user')

@section('title', 'Mengerjakan: ' . $quiz->title)

@push('styles')
    <style>
        /* Focus Mode: Hide main navbar */
        nav.navbar.sticky-top {
            display: none !important;
        }

        body {
            background-color: #f8fafc !important;
        }

        /* Microsoft Form Style Timer Bar */
        .timer-sticky-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-bottom: 2px solid #6366f1;
            padding: 12px 0;
        }

        .option-card {
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid #f1f5f9;
            position: relative;
            background: white;
        }

        .option-card:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .option-card.selected {
            border-color: #6366f1;
            background: #f5f3ff;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.1);
        }

        .option-card input {
            display: none;
        }

        .timer-display-box {
            font-family: 'Inter', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 800;
            font-size: 1.4rem;
            color: #1e293b;
        }

        .question-card {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        }

        .badge-step {
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.6rem 1.2rem;
        }

        /* Responsive Improvements */
        @media (max-width: 991.98px) {
            .quiz-container {
                margin-top: 60px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Microsoft Forms Style Sticky Timer -->
    <div id="stickyTimerBar" class="timer-sticky-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary-subtle p-2 rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-stopwatch text-primary fs-5"></i>
                </div>
                <div class="d-flex flex-column">
                    <span class="text-secondary small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.05em;">Waktu Sisa</span>
                    <span id="timer" class="timer-display-box leading-none">--:--</span>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-block text-end me-2">
                    <div class="text-dark fw-bold small">{{ $quiz->title }}</div>
                    <div class="text-muted" style="font-size: 0.7rem;">Sesi Kuis Berlangsung</div>
                </div>
                <a href="{{ route('user.quizzes.finish', $quiz) }}" 
                   class="btn btn-danger btn-sm px-4 rounded-pill fw-bold"
                   onclick="return confirm('Selesaikan kuis sekarang?')">
                    KIRIM <i class="bi bi-send-fill ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row quiz-container" style="margin-top: 80px;">
        <!-- Main Question Area -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 fw-bold">
                                Soal {{ ($currentIndex ?? 0) + 1 }} / {{ $totalQuestions ?? $quiz->questions->count() }}
                            </span>
                        </div>
                        <h6 class="text-secondary mb-0 fw-medium d-none d-md-block">{{ $quiz->title }}</h6>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.quizzes.submit-answer', [$quiz, $question]) }}" method="POST" id="answerForm">
                        @csrf
                        
                        <div class="mb-5">
                            <h3 class="fw-bold text-dark lh-base mb-4">{!! nl2br(e($question->question_text)) !!}</h3>

                            @if($question->image)
                                <div class="mb-4 text-center bg-light p-2 rounded">
                                    <img src="{{ asset('storage/' . $question->image) }}" class="img-fluid rounded shadow-sm" alt="Question" style="max-height: 450px; border: 1px solid #dee2e6;">
                                </div>
                            @endif
                        </div>

                        <div class="options-list grid gap-3">
                            @foreach($question->options as $index => $option)
                                <label class="option-card d-flex align-items-center p-3 p-md-4 rounded-4 mb-3 {{ isset($userAnswer) && $userAnswer->option_id == $option->id ? 'selected' : '' }}">
                                    <input type="radio" name="option_id" value="{{ $option->id }}" 
                                           {{ (isset($userAnswer) && $userAnswer->option_id == $option->id) ? 'checked' : '' }}
                                           onchange="submitWithDelay(this);">
                                    
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle border d-flex align-items-center justify-content-center fw-bold bg-white text-secondary" style="width: 36px; height: 36px; border-width: 2px !important;">
                                            {{ chr(65 + $index) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fs-5 text-dark">{{ $option->option_text }}</span>
                                    </div>
                                    @if(isset($userAnswer) && $userAnswer->option_id == $option->id)
                                        <div class="ms-auto text-primary">
                                            <i class="bi bi-check-circle-fill fs-4"></i>
                                        </div>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Navigation Logic -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>Jawaban Anda akan tersimpan otomatis.</p>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4 sticky-lg-top" style="top: 80px;">
                <div class="card-body">
                    <h5 class="fw-bold mb-4"><i class="bi bi-graph-up me-2 text-primary"></i>Ringkasan Kuis</h5>
                    
                    @if(isset($progress))
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-secondary small fw-bold">Progress Pengerjaan</span>
                                <span class="badge bg-success-subtle text-success rounded-pill">{{ $progress['percentage'] }}%</span>
                            </div>
                            <div class="progress rounded-pill shadow-none" style="height: 12px; background-color: #f1f5f9;">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated rounded-pill" 
                                     style="width: {{ $progress['percentage'] }}%"></div>
                            </div>
                            <div class="mt-2 text-center text-secondary small">
                                <strong>{{ $progress['answered'] }}</strong> dari <strong>{{ $progress['total'] }}:</strong> Soal terjawab
                            </div>
                        </div>
                    @endif

                    <hr class="my-4 border-light">

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-light btn-sm text-secondary border" disabled>
                            <i class="bi bi-lock-fill me-1"></i>Id Sesi: {{ session()->getId() }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Timer Logic - Rely on Server Time as Truth
        const serverSeconds = {{ $remainingSeconds }};
        
        // Calculate target end time based on local clock to ensure smooth countdown
        // independent of processing delays
        const endTime = Date.now() + (serverSeconds * 1000);

        const timerDisplay = document.getElementById('timer');
        const stickyBar = document.getElementById('stickyTimerBar');

        function updateTimer() {
            const now = Date.now();
            let remaining = Math.max(0, Math.floor((endTime - now) / 1000));

            if (remaining <= 0) {
                window.location.href = "{{ route('user.quizzes.finish', $quiz) }}?timeout=1";
                return;
            }

            const h = Math.floor(remaining / 3600);
            const m = Math.floor((remaining % 3600) / 60);
            const s = remaining % 60;

            let display = '';
            if (h > 0) display += (h < 10 ? '0' : '') + h + ':';
            display += (m < 10 ? '0' : '') + m + ':';
            display += (s < 10 ? '0' : '') + s;

            timerDisplay.textContent = display;

            // Visual feedback for low time
            if (remaining < 60) {
                timerDisplay.classList.add('timer-low');
            } else {
                timerDisplay.classList.remove('timer-low');
            }
        }

        setInterval(updateTimer, 1000);
        updateTimer();

        // Submit with small delay for a smoother experience
        function submitWithDelay(input) {
            const label = input.closest('.option-card');
            label.classList.add('selected');
            
            // Highlight selected icon
            const currentSelected = document.querySelector('.option-card.selected');
            if(currentSelected) currentSelected.classList.remove('selected');
            label.classList.add('selected');

            // Small delay to let user see selection
            setTimeout(() => {
                input.form.submit();
            }, 150);
        }

        // Hide sticky bar when scrolled far down (optional, like MS Forms)
        window.addEventListener('scroll', () => {
            // MS Forms usually keeps it sticky, so we will too.
        });
    </script>
@endpush
