<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Evaluasi</title>
    <style>
        @page {
            margin: 1cm 1cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #1e1b4b;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            color: #6b7280;
            font-size: 10px;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .meta-label {
            font-weight: bold;
            color: #4b5563;
            width: 100px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        table.data-table th {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            text-transform: uppercase;
            border: 1px solid #4338ca;
        }

        table.data-table td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            vertical-align: middle;
        }

        table.data-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
            display: inline-block;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-score {
            background-color: #f3f4f6;
            color: #1f2937;
            border: 1px solid #d1d5db;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 30px;
            font-size: 9px;
            text-align: center;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Hasil Evaluasi</h1>
        <p>{{ config('app.name') }} &bull; Generated on {{ date('d F Y, H:i') }}</p>
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Filter Kuis:</td>
            <td>{{ $quizTitle ?? 'Semua Kuis' }}</td>
            <td class="meta-label">Total Peserta:</td>
            <td>{{ count($results) }}</td>
        </tr>
        <tr>
            <td class="meta-label">Dicetak Oleh:</td>
            <td>{{ Auth::user()->name ?? 'System' }}</td>
            <td class="meta-label" colspan="2"></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30" class="text-center">No</th>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th>Judul Kuis</th>
                <th width="40" class="text-center">Skor</th>
                <th width="40" class="text-center">Benar</th>
                <th width="40" class="text-center">Salah</th>
                <th width="80" class="text-center">Durasi</th>
                <th width="80" class="text-center">Tanggal</th>
                <th width="80" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $result)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $result->user->name }}</strong>
                    </td>
                    <td>{{ $result->user->email }}</td>
                    <td>{{ $result->quiz->title }}</td>
                    <td class="text-center">
                        <span class="badge badge-score">{{ floatval($result->total_score) }}</span>
                    </td>
                    <td class="text-center" style="color: green;">{{ $result->correct_answers }}</td>
                    <td class="text-center" style="color: red;">{{ $result->wrong_answers }}</td>
                    <td class="text-center">{{ $result->formatted_completion_time }}</td>
                    <td class="text-center">{{ $result->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $result->is_passed ? 'badge-success' : 'badge-danger' }}">
                            {{ $result->is_passed ? 'LULUS' : 'GAGAL' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ config('app.name') }} - Laporan Resmi
    </div>
</body>

</html>