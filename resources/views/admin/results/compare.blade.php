@extends('layouts.admin')

@section('title', 'Komparasi Jawaban')
@section('page-title', 'Komparasi Jawaban Peserta')

@section('content')
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $quiz->title }}</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.results.compare.export.excel', ['ids' => $results->pluck('id')->toArray()]) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Excel
                </a>
                <a href="{{ route('admin.results.compare.export.pdf', ['ids' => $results->pluck('id')->toArray()]) }}" target="_blank" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                </a>
                <a href="{{ route('admin.results.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 40%">Soal</th>
                            @foreach($results as $result)
                                <th class="text-center align-top">
                                    <div class="fw-bold">{{ $result->user->name }}</div>
                                    <div class="badge bg-{{ $result->total_score >= 70 ? 'success' : 'danger' }} mt-1">
                                        Skor: {{ floatval($result->total_score) }}
                                    </div>
                                    <div class="small text-muted mt-1">
                                        {{ $result->formatted_completion_time }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quiz->questions as $index => $question)
                            <tr>
                                <td>
                                    <div class="mb-2"><strong>No. {{ $index + 1 }}</strong></div>
                                    <p class="mb-2">{{ $question->question_text }}</p>
                                    <div class="alert alert-light border py-1 px-2 mb-0">
                                        <small class="fw-bold text-success">
                                            <i class="bi bi-key-fill me-1"></i> Kunci: 
                                            @foreach($question->options as $option)
                                                @if($option->is_correct) 
                                                    {{ $option->option_text }}
                                                @endif
                                            @endforeach
                                        </small>
                                    </div>
                                </td>
                                @foreach($results as $result)
                                    @php
                                        $answer = $result->user->answers->where('question_id', $question->id)->first();
                                        $selectedOption = $answer ? $question->options->where('id', $answer->option_id)->first() : null;
                                        $isCorrect = $answer ? $answer->isCorrect() : false;
                                        $bgClass = $isCorrect ? 'bg-success bg-opacity-10' : ($answer ? 'bg-danger bg-opacity-10' : 'bg-light');
                                    @endphp
                                    <td class="{{ $bgClass }} text-center align-middle">
                                        @if($selectedOption)
                                            <span class="{{ $isCorrect ? 'text-success fw-bold' : 'text-danger' }}">
                                                {{ $selectedOption->option_text }}
                                            </span>
                                            @if($isCorrect)
                                                 <br><i class="bi bi-check-circle-fill text-success fs-5"></i>
                                            @else
                                                 <br><i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                            @endif
                                        @else
                                            <span class="text-muted fst-italic">Tidak dijawab</span>
                                            <br><i class="bi bi-dash-circle text-muted fs-5"></i>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
