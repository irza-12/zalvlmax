<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Komparasi Jawaban</title>
    <style>
        @page {
            margin: 1cm;
            size: A4 landscape;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.3;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #1e1b4b;
            text-transform: uppercase;
            font-size: 16px;
        }

        .header h2 {
            margin: 5px 0 0;
            font-size: 12px;
            color: #4b5563;
            font-weight: normal;
        }

        .meta-info {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .meta-info td {
            padding: 4px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 120px;
            color: #555;
        }

        .summary-box {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .summary-box th {
            background: #f3f4f6;
            padding: 8px;
            text-align: left;
            border: 1px solid #e5e7eb;
            font-size: 10px;
        }

        .summary-box td {
            padding: 8px;
            border: 1px solid #e5e7eb;
            text-align: center;
            width:
                {{ 60 / count($results) }}
                %;
        }

        .score-large {
            font-size: 14px;
            font-weight: bold;
        }

        .score-pass {
            color: #059669;
        }

        .score-fail {
            color: #dc2626;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th {
            background-color: #4f46e5;
            color: white;
            padding: 8px;
            border: 1px solid #312e81;
            text-align: center;
            font-weight: bold;
        }

        .data-table td {
            border: 1px solid #d1d5db;
            padding: 6px;
            vertical-align: top;
        }

        .question-col {
            width: 30%;
            text-align: left;
            background: #f9fafb;
        }

        .answer-col {
            text-align: center;
        }

        .correct {
            background-color: #d1fae5;
            color: #065f46;
            font-weight: bold;
            border-color: #a7f3d0;
        }

        .wrong {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .empty {
            background-color: #f3f4f6;
            color: #6b7280;
            font-style: italic;
        }

        .key-badge {
            margin-top: 5px;
            font-size: 9px;
            color: #047857;
            background: #ecfdf5;
            padding: 2px 5px;
            border: 1px solid #6ee7b7;
            border-radius: 3px;
            display: inline-block;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            font-weight: bold;
            font-size: 12px;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
            border: none;
        }

        .btn-secondary {
            background-color: white;
            color: #333;
            border: 1px solid #ccc;
            margin-left: 10px;
        }

        .toolbar {
            padding: 15px;
            background: #f3f4f6;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="no-print toolbar" style="display: flex; justify-content: space-between;">
        <div>
            <strong style="font-size: 14px;">Pratinjau Cetak PDF</strong><br>
            <span style="color: #666;">Gunakan Ctrl+P (Windows) atau Cmd+P (Mac) untuk menyimpan.</span>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary">Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>

    <div class="header">
        <h1>Laporan Komparasi Jawaban</h1>
        <h2>{{ $quiz->title }}</h2>
        <div style="margin-top: 5px; font-size: 9px; color: #888;">
            Dicetak pada: {{ now()->format('d F Y, H:i') }} &bull; Oleh: {{ Auth::user()->name }}
        </div>
    </div>

    <!-- Ringkasan Peserta -->
    <table class="summary-box">
        <thead>
            <tr>
                <th style="width: 30%;">Peserta</th>
                @foreach($results as $result)
                    <th style="text-align: center;">{{ $result->user->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left; font-weight: bold;">Skor Akhir</td>
                @foreach($results as $result)
                    <td>
                        <div class="score-large {{ $result->is_passed ? 'score-pass' : 'score-fail' }}">
                            {{ floatval($result->total_score) }}
                        </div>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td style="text-align: left;">Durasi & Status</td>
                @foreach($results as $result)
                    <td>
                        {{ $result->formatted_completion_time }}<br>
                        <span
                            style="font-weight: bold; font-size: 9px; text-transform: uppercase; color: {{ $result->is_passed ? '#059669' : '#dc2626' }}">
                            {{ $result->is_passed ? 'Lulus' : 'Tidak Lulus' }}
                        </span>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td style="text-align: left;">Detail Jawaban</td>
                @foreach($results as $result)
                    <td>
                        <span style="color: green;">{{ $result->correct_answers }} Benar</span> &bull;
                        <span style="color: red;">{{ $result->wrong_answers }} Salah</span>
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30%; text-align: left;">Pertanyaan</th>
                @foreach($results as $result)
                    <th>{{ $result->user->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($quiz->questions as $index => $question)
                <tr>
                    <td class="question-col">
                        <div style="margin-bottom: 4px;"><strong>No. {{ $index + 1 }}</strong></div>
                        {{ $question->question_text }}
                        <div class="key-badge">
                            Kunci:
                            @foreach($question->options as $option)
                                @if($option->is_correct) {{ $option->option_text }} @endif
                            @endforeach
                        </div>
                    </td>
                    @foreach($results as $result)
                        @php
                            $answer = ($result->session && $result->session->answers->where('question_id', $question->id)->count() > 0)
                                ? $result->session->answers->where('question_id', $question->id)->first()
                                : $result->user->answers->where('question_id', $question->id)->first();
                            $selectedOption = $answer ? $question->options->where('id', $answer->option_id)->first() : null;
                            $isCorrect = $answer ? $answer->isCorrect() : false;
                            $cellClass = $isCorrect ? 'correct' : ($answer ? 'wrong' : 'empty');
                        @endphp
                        <td class="answer-col {{ $cellClass }}">
                            @if($selectedOption)
                                <strong>{{ $selectedOption->option_text }}</strong>
                                @if(!$isCorrect)
                                    <div style="font-size: 8px; margin-top: 2px; text-transform: uppercase;">Salah</div>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div
        style="margin-top: 30px; text-align: center; font-size: 9px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px;">
        {{ config('app.name') }} &bull; Laporan Resmi
    </div>

</body>

</html>