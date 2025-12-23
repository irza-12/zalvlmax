<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .correct {
            color: green;
            font-weight: bold;
        }

        .wrong {
            color: red;
        }

        .missing {
            color: #888;
            font-style: italic;
        }
    </style>
</head>

<body>
    <h2>Komparasi Jawaban Peserta</h2>
    <p>Kuis: <strong>{{ $quiz->title }}</strong></p>
    <p>Tanggal Ekspor: {{ now()->format('d/m/Y H:i') }}</p>

    <table border="1" style="margin-bottom: 20px; width: auto;">
        <tr>
            <th colspan="2" style="background-color: #d1d1d1;">Ringkasan Komparasi</th>
        </tr>
        <tr>
            <td>Total Peserta</td>
            <td>{{ $results->count() }} Orang</td>
        </tr>
        <tr>
            <td>Rata-rata Skor</td>
            <td>{{ number_format($results->avg('total_score'), 2) }}</td>
        </tr>
        <tr>
            <td>Skor Tertinggi</td>
            <td>{{ number_format($results->max('total_score'), 2) }}</td>
        </tr>
        <tr>
            <td>Skor Terendah</td>
            <td>{{ number_format($results->min('total_score'), 2) }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 300px;">Soal</th>
                @foreach($results as $result)
                    <th class="text-center">
                        {{ $result->user->name }}<br>
                        (Skor: {{ floatval($result->total_score) }})
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($quiz->questions as $index => $question)
                <tr>
                    <td>
                        <strong>No. {{ $index + 1 }}</strong><br>
                        {{ $question->question_text }}<br><br>
                        <small>Kunci:
                            @foreach($question->options as $option)
                                @if($option->is_correct) {{ $option->option_text }} @endif
                            @endforeach
                        </small>
                    </td>
                    @foreach($results as $result)
                        @php
                            $answer = $result->user->answers->where('question_id', $question->id)->first();
                            $selectedOption = $answer ? $question->options->where('id', $answer->option_id)->first() : null;
                            $isCorrect = $answer ? $answer->isCorrect() : false;
                        @endphp
                        <td class="text-center">
                            @if($selectedOption)
                                <span class="{{ $isCorrect ? 'correct' : 'wrong' }}">
                                    {{ $selectedOption->option_text }}
                                    ({{ $isCorrect ? 'BENAR' : 'SALAH' }})
                                </span>
                            @else
                                <span class="missing">Tidak dijawab</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>