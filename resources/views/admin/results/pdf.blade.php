<!DOCTYPE html>
<html>

<head>
    <title>Laporan Hasil Evaluasi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .meta {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Hasil Evaluasi {{ config('app.name') }}</h2>
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

    <div class="meta">
        <strong>Filter Kuis:</strong> {{ request('quiz_title') ?? 'Semua Kuis' }} <br>
        <strong>Total Peserta:</strong> {{ count($results) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th>Kuis</th>
                <th>Skor</th>
                <th>Benar</th>
                <th>Salah</th>
                <th>Waktu Pengerjaan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->user->name }}</td>
                    <td>{{ $result->user->email }}</td>
                    <td>{{ $result->quiz->title }}</td>
                    <td>{{ floatval($result->total_score) }}</td>
                    <td>{{ $result->correct_answers }}</td>
                    <td>{{ $result->wrong_answers }}</td>
                    <td>{{ $result->formatted_completion_time }}</td>
                    <td>{{ $result->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>