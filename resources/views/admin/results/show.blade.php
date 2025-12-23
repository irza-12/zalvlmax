@extends('layouts.admin')

@section('title', 'Detail Hasil')
@section('page-title', 'Detail Hasil Evaluasi')

@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Informasi Peserta</h6>
                </div>
                <div class="card-body">
                    <h5>{{ $result->user->name }}</h5>
                    <p class="text-muted mb-0">{{ $result->user->email }}</p>
                    <hr>
                    <small class="text-muted d-block">Waktu Pengerjaan:</small>
                    <strong>{{ $result->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</strong>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Ringkasan Skor</h6>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 fw-bold text-{{ $result->total_score >= 70 ? 'success' : 'danger' }}">
                        {{ floatval($result->total_score) }}
                    </h1>
                    <p class="text-muted">Total Poin</p>

                    <div class="row mt-3">
                        <div class="col-6 border-end">
                            <h5 class="text-success mb-0">{{ $result->correct_answers }}</h5>
                            <small>Benar</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-danger mb-0">{{ $result->wrong_answers }}</h5>
                            <small>Salah</small>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">Durasi:</small>
                        <span class="fw-bold">{{ $result->formatted_completion_time }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Detail Jawaban: {{ $result->quiz->title }}</h6>
                    <a href="{{ route('admin.results.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    @foreach($result->quiz->questions as $index => $question)
                        @php
                            $userAnswer = $result->user->answers
                                ->where('question_id', $question->id)
                                ->first();
                            $isCorrect = $userAnswer ? $userAnswer->isCorrect() : false;
                        @endphp

                        <div class="mb-4 pb-3 border-bottom last-no-border">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-1">
                                    No. {{ $index + 1 }}
                                    @if($isCorrect)
                                        <span class="badge bg-success ms-2"><i class="bi bi-check"></i> Benar</span>
                                    @elseif(!$result->completion_time && !$userAnswer)
                                        <span class="badge bg-secondary ms-2 text-white"><i class="bi bi-hourglass"></i> Belum
                                            Dijawab</span>
                                    @else
                                        <span class="badge bg-danger ms-2"><i class="bi bi-x"></i> Salah</span>
                                    @endif
                                </h6>
                                <span class="badge bg-light text-dark border">{{ $question->score }} Poin</span>
                            </div>

                            <p class="mb-2">{{ $question->question_text }}</p>

                            <div class="bg-light p-3 rounded">
                                <ul class="list-unstyled mb-0">
                                    @foreach($question->options as $option)
                                        @php
                                            $isSelected = $userAnswer && $userAnswer->option_id == $option->id;
                                            $isAnswerCorrect = $option->is_correct;

                                            $class = '';
                                            $icon = 'bi-circle';

                                            if ($isSelected && $isAnswerCorrect) {
                                                $class = 'text-success fw-bold';
                                                $icon = 'bi-check-circle-fill';
                                            } elseif ($isSelected && !$isAnswerCorrect) {
                                                $class = 'text-danger fw-bold';
                                                $icon = 'bi-x-circle-fill';
                                            } elseif (!$isSelected && $isAnswerCorrect) {
                                                $class = 'text-success';
                                                $icon = 'bi-check-circle';
                                            }
                                        @endphp
                                        <li class="mb-2 {{ $class }}">
                                            <i class="bi {{ $icon }} me-2"></i>
                                            {{ $option->option_text }}
                                            @if($isSelected) <span class="badge bg-secondary ms-2"
                                            style="font-size: 0.6rem;">Dipilih User</span> @endif
                                            @if($isAnswerCorrect) <span class="badge bg-success ms-2"
                                            style="font-size: 0.6rem;">Jawaban Benar</span> @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection