<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Komparasi Jawaban - {{ $quiz->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
                margin: 0;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #dee2e6 !important;
            }
        }

        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .report-header {
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .table-compare th {
            background-color: #f1f3f5;
        }

        .correct-bg {
            background-color: #d4edda !important;
        }

        .wrong-bg {
            background-color: #f8d7da !important;
        }

        .missing-bg {
            background-color: #e9ecef !important;
        }
    </style>
</head>

<body class="p-4">
    <div class="container-fluid">
        <div class="no-print mb-4 d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm">
            <div>
                <h4 class="mb-0">Pratinjau Cetak PDF</h4>
                <p class="text-muted mb-0 small">Gunakan fitur cetak browser (Ctrl+P) untuk menyimpan sebagai PDF</p>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Cetak Sekarang
                </button>
                <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <div class="report-header d-flex justify-content-between align-items-end">
                    <div>
                        <h2 class="fw-bold mb-1">LAPORAN KOMPARASI JAWABAN</h2>
                        <h4 class="text-primary mb-0">{{ $quiz->title }}</h4>
                    </div>
                    <div class="text-end">
                        <p class="mb-0">Tanggal Cetak: <strong>{{ now()->format('d F Y, H:i') }}</strong></p>
                        <p class="mb-0 text-muted small">Aplikasi {{ config('app.name') }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr class="table-light">
                                <th colspan="2">Statistik Grup</th>
                            </tr>
                            <tr>
                                <td>Jumlah Peserta</td>
                                <td><strong>{{ $results->count() }}</strong></td>
                            </tr>
                            <tr>
                                <td>Rata-rata Skor</td>
                                <td><strong>{{ number_format($results->avg('total_score'), 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td>Skor Tertinggi</td>
                                <td class="text-success"><strong>{{ floatval($results->max('total_score')) }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Skor Terendah</td>
                                <td class="text-danger"><strong>{{ floatval($results->min('total_score')) }}</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mb-4 g-3">
                    @foreach($results as $result)
                        <div class="col">
                            <div class="p-3 border rounded bg-light">
                                <h6 class="fw-bold mb-1 text-truncate">{{ $result->user->name }}</h6>
                                <div class="small">
                                    Skor: <strong>{{ floatval($result->total_score) }}</strong><br>
                                    Benar: {{ $result->correct_answers }} | Salah: {{ $result->wrong_answers }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <table class="table table-bordered table-compare align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40%">Pertanyaan & Kunci Jawaban</th>
                            @foreach($results as $result)
                                <th class="text-center">{{ $result->user->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quiz->questions as $index => $question)
                            <tr>
                                <td>
                                    <div class="fw-bold mb-1">No. {{ $index + 1 }}</div>
                                    <p class="mb-2 small">{{ $question->question_text }}</p>
                                    <div class="p-1 px-2 border rounded bg-white small text-success fst-italic">
                                        Kunci:
                                        @foreach($question->options as $option)
                                            @if($option->is_correct) {{ $option->option_text }} @endif
                                        @endforeach
                                    </div>
                                </td>
                                @foreach($results as $result)
                                    @php
                                        $answer = $result->user->answers->where('question_id', $question->id)->first();
                                        $selectedOption = $answer ? $question->options->where('id', $answer->option_id)->first() : null;
                                        $isCorrect = $answer ? $answer->isCorrect() : false;
                                        $cellClass = $isCorrect ? 'correct-bg' : ($answer ? 'wrong-bg' : 'missing-bg');
                                    @endphp
                                    <td class="{{ $cellClass }} text-center small">
                                        @if($selectedOption)
                                            <div class="fw-bold {{ $isCorrect ? 'text-success' : 'text-danger' }}">
                                                {{ $selectedOption->option_text }}
                                            </div>
                                            <div class="mt-1 small opacity-75">
                                                ({{ $isCorrect ? 'BENAR' : 'SALAH' }})
                                            </div>
                                        @else
                                            <span class="text-muted">Tidak dijawab</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-5 pt-4 border-top text-center text-muted small">
                    <p>Laporan ini dihasilkan secara otomatis oleh Sistem Evaluasi {{ config('app.name') }}.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>

</html>