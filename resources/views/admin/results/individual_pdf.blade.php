<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sertifikat Hasil - {{ $result->user->name }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #334155;
            background-color: #ffffff;
        }

        /* --- DEKORASI --- */
        .accent-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 50px;
            background-color: #1e3a8a;
            /* Biru Navy */
            z-index: -10;
        }

        .accent-strip {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 50px;
            width: 10px;
            background-color: #f59e0b;
            /* Emas */
            z-index: -9;
        }

        /* --- CONTAINER --- */
        .main-wrapper {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }

        .main-cell {
            vertical-align: middle;
            padding-left: 100px;
            padding-right: 60px;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        /* --- HEADER --- */
        .header-box {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-text {
            color: #1e3a8a;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .sub-logo {
            color: #64748b;
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 5px;
        }

        /* --- CONTENT --- */
        .cert-title {
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .recipient {
            font-size: 38px;
            color: #0f172a;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
            border-bottom: 1px solid #cbd5e1;
            display: inline-block;
            padding-bottom: 10px;
            min-width: 400px;
        }

        .description {
            font-size: 16px;
            color: #475569;
            margin-bottom: 20px;
        }

        .quiz-name {
            color: #1e3a8a;
            font-weight: bold;
            font-size: 22px;
            margin-bottom: 20px;
            display: block;
        }

        /* --- STATS & STATUS --- */
        .stats-container {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background-color: #f8fafc;
            width: 100%;
            margin-bottom: 20px;
            overflow: hidden;
            /* Rounded corner fix */
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stats-table td {
            text-align: center;
            padding: 15px;
            border-right: 1px solid #e2e8f0;
            width: 33.33%;
        }

        .stats-table td:last-child {
            border-right: none;
        }

        .s-val {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .s-lbl {
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            margin-top: 5px;
        }

        /* STATUS BANNER BESAR */
        .status-header {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            margin-top: 10px;
        }

        .status-banner {
            padding: 15px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            display: block;
            /* Full width block */
            border: 2px solid transparent;
        }

        .status-pass {
            background-color: #dcfce7;
            color: #166534;
            border-color: #bbf7d0;
        }

        .status-fail {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        /* --- FOOTER --- */
        .footer-table {
            width: 100%;
            margin-top: 30px;
        }

        .issue-date {
            font-size: 12px;
            color: #64748b;
        }

        .sign-line {
            border-bottom: 1px solid #1e293b;
            margin-bottom: 5px;
            height: 50px;
            width: 220px;
        }

        .sign-name {
            font-weight: bold;
            font-size: 14px;
            color: #0f172a;
        }

        .id-code {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 9px;
            color: #cbd5e1;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <div class="accent-sidebar"></div>
    <div class="accent-strip"></div>

    <!-- Watermark -->
    <div
        style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 100px; color: rgba(30, 58, 138, 0.03); z-index: -5; font-weight: bold; white-space: nowrap; pointer-events: none;">
        OFFICIAL RESULT
    </div>

    <div class="id-code">
        DOC: {{ $result->id }}-{{ strtoupper(substr(md5($result->created_at), 0, 6)) }}
    </div>

    <table class="main-wrapper">
        <tr>
            <td class="main-cell">

                <!-- 1. Header -->
                <div class="header-box">
                    <div class="logo-text">{{ config('app.name', 'ZalvlmaX') }}</div>
                    <div class="sub-logo">Laporan Hasil Evaluasi Resmi</div>
                </div>

                <!-- 2. Penerima -->
                <div class="cert-title">Diberikan Kepada:</div>
                <div class="recipient">{{ $result->user->name }}</div>

                <div class="description">
                    Telah menyelesaikan evaluasi pemahaman pada materi:
                </div>
                <div class="quiz-name">{{ $result->quiz->title }}</div>

                <!-- 3. Statistik (Nilai, Benar, Durasi) -->
                <div class="stats-container">
                    <table class="stats-table">
                        <tr>
                            <td>
                                <div class="s-val">{{ number_format((float) $result->percentage, 1) }}%</div>
                                <div class="s-lbl">Nilai Akhir</div>
                            </td>
                            <td>
                                <div class="s-val">{{ $result->correct_answers }} / {{ $result->total_questions }}</div>
                                <div class="s-lbl">Jawaban Benar</div>
                            </td>
                            <td>
                                <div class="s-val">{{ $result->formatted_completion_time }}</div>
                                <div class="s-lbl">Durasi</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- 4. STATUS KELULUSAN (BESAR & JELAS) -->
                <div class="status-header">Status Kelulusan:</div>
                @if($result->is_passed)
                    <div class="status-banner status-pass">LULUS (PASSED)</div>
                @else
                    <div class="status-banner status-fail">TIDAK LULUS (FAILED)</div>
                @endif

                <!-- 5. Footer -->
                <table class="footer-table">
                    <tr>
                        <td valign="bottom" style="width: 60%;">
                            <div class="issue-date">
                                Tanggal Terbit:<br>
                                <strong>{{ $result->created_at->isoFormat('D MMMM YYYY') }}</strong>
                            </div>
                        </td>
                        <td valign="bottom" align="right">
                            <div class="sign-line"></div>
                            <div class="sign-name">Admin Evaluasi</div>
                            <div style="font-size: 11px; color: #64748b;">Penanggung Jawab</div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>