<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            height: 45px;
            vertical-align: middle;
        }

        .subtitle {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            height: 35px;
            vertical-align: middle;
            color: #1f2937;
        }

        .meta {
            font-size: 12px;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 5px;
            vertical-align: top;
        }

        .header-row {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .sub-header {
            background-color: #e5e7eb;
            font-weight: bold;
            text-align: center;
        }

        .question-col {
            width: 300px;
            text-align: left;
            background-color: #f9fafb;
            font-weight: bold;
        }

        .answer-col {
            width: 150px;
            text-align: center;
            vertical-align: middle;
        }

        .correct {
            background-color: #d1fae5;
            color: #065f46;
            font-weight: bold;
        }

        .wrong {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .empty {
            background-color: #f3f4f6;
            color: #6b7280;
            font-style: italic;
        }

        .score-box {
            border: 1px solid #000;
            text-align: center;
            font-weight: bold;
        }

        .pass {
            color: #059669;
        }

        .fail {
            color: #dc2626;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="{{ count($results) + 1 }}" class="title">LAPORAN KOMPARASI JAWABAN</td>
        </tr>
        <tr>
            <td colspan="{{ count($results) + 1 }}" class="subtitle">{{ $quiz->title }}</td>
        </tr>
        <tr>
            <td colspan="{{ count($results) + 1 }}"></td>
        </tr>

        <tr>
            <td class="meta"><strong>Tanggal Export:</strong></td>
            <td colspan="{{ count($results) }}" class="meta">{{ now()->format('d F Y H:i') }}</td>
        </tr>
        <tr>
            <td class="meta"><strong>Total Peserta:</strong></td>
            <td colspan="{{ count($results) }}" class="meta">{{ count($results) }} Orang</td>
        </tr>
        <tr>
            <td class="meta"><strong>Oleh:</strong></td>
            <td colspan="{{ count($results) }}" class="meta">{{ Auth::user()->name }}</td>
        </tr>
        <tr>
            <td colspan="{{ count($results) + 1 }}"></td>
        </tr>
    </table>

    <table>
        <!-- Table Header -->
        <thead>
            <tr>
                <th class="header-row" height="40">PERTANYAAN</th>
                @foreach($results as $result)
                    <th class="header-row">{{ strtoupper($result->user->name) }}</th>
                @endforeach
            </tr>
            <tr>
                <th class="sub-header">SKOR AKHIR</th>
                @foreach($results as $result)
                    <th class="sub-header @if($result->is_passed) pass @else fail @endif" style="font-size: 14px;">
                        {{ floatval($result->total_score) }}
                    </th>
                @endforeach
            </tr>
            <tr>
                <th class="sub-header">STATUS</th>
                @foreach($results as $result)
                    <th class="sub-header" style="color: {{ $result->is_passed ? '#059669' : '#dc2626' }}">
                        {{ $result->is_passed ? 'LULUS' : 'TIDAK LULUS' }}
                    </th>
                @endforeach
            </tr>
            <tr>
                <th class="sub-header">DURASI</th>
                @foreach($results as $result)
                    <th class="sub-header" style="font-weight: normal;">
                        {{ $result->formatted_completion_time }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <!-- Data Body -->
        <tbody>
            @foreach($quiz->questions as $index => $question)
                <tr>
                    <td class="question-col">
                        No. {{ $index + 1 }}<br>
                        {{ $question->question_text }}<br>
                        <span style="color: #047857;">[Kunci:
                            @foreach($question->options as $option)
                                @if($option->is_correct) {{ $option->option_text }} @endif
                            @endforeach
                            ]
                        </span>
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
                                {{ $selectedOption->option_text }}
                                <br>
                                @if($isCorrect)
                                    <span style="color: #065f46; font-size: 10px;">(BENAR)</span>
                                @else
                                    <span style="color: #991b1b; font-size: 10px;">(SALAH)</span>
                                @endif
                            @else
                                (Tidak dijawab)
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>