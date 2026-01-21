<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>E-Certificate - {{ $result->user->name }}</title>
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

        /* --- DEKORASI BACKGROUND --- */
        .accent-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 60px;
            background-color: #1e3a8a;
            /* Biru Navy */
            z-index: -10;
        }

        .accent-strip {
            position: fixed;
            top: 40px;
            bottom: 40px;
            left: 60px;
            width: 8px;
            background-color: #f59e0b;
            /* Emas */
            z-index: -9;
        }

        /* Dekorasi Segitiga Pojok Kanan Atas */
        .top-decor {
            position: fixed;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background-color: #f1f5f9;
            transform: rotate(45deg) translate(100px, -100px);
            /* Trik CSS kotak diputar */
            z-index: -20;
        }

        /* --- CONTAINER UTAMA (TABEL) --- */
        /* Menggunakan tabel 100% tinggi agar vertikal center mudah */
        .main-wrapper {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }

        .main-cell {
            vertical-align: middle;
            padding-left: 100px;
            /* Memberi ruang untuk sidebar kiri */
            padding-right: 50px;
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
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .sub-logo {
            color: #64748b;
            font-size: 14px;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 5px;
        }

        /* --- CONTENT BODY --- */
        .cert-title {
            font-size: 16px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .recipient {
            font-size: 42px;
            color: #0f172a;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 25px;
            line-height: 1.2;
        }

        .description {
            font-size: 16px;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 30px;
            max-width: 800px;
        }

        .quiz-name {
            color: #1e3a8a;
            font-weight: bold;
            font-size: 20px;
        }

        /* --- STATS BOX --- */
        .stats-container {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8fafc;
            display: inline-block;
            width: 90%;
            margin-bottom: 30px;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stats-table td {
            text-align: center;
            padding: 10px;
            border-right: 1px solid #cbd5e1;
            width: 25%;
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

        .pass-badge {
            color: #166534;
            background: #dcfce7;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .fail-badge {
            color: #991b1b;
            background: #fee2e2;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        /* --- FOOTER --- */
        .footer-table {
            width: 100%;
            margin-top: 20px;
        }

        .issue-date {
            font-size: 13px;
            color: #64748b;
        }

        .signature-area {
            text-align: center;
            width: 200px;
            float: right;
        }

        .sign-line {
            border-bottom: 1px solid #1e293b;
            margin-bottom: 5px;
            height: 40px;
            /* Space Tanda Tangan */
        }

        .sign-name {
            font-weight: bold;
            font-size: 14px;
            color: #0f172a;
        }

        .sign-role {
            font-size: 11px;
            color: #64748b;
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
    <!-- Dekorasi Fixed -->
    <div class="accent-sidebar"></div>
    <div class="accent-strip"></div>
    <div class="top-decor"></div>
    <div class="id-code">
        DOC: {{ $result->id }}-{{ strtoupper(substr(md5($result->created_at), 0, 6)) }} | GEN:
        {{ now()->format('Y-m-d H:i') }}
    </div>

    <!-- Layout Utama Menggunakan Tabel Penuh -->
    <table class="main-wrapper">
        <tr>
            <td class="main-cell">

                <!-- Header -->
                <div class="header-box">
                    <div class="logo-text">{{ config('app.name', 'ZalvlmaX') }}</div>
                    <div class="sub-logo">Official Competency Report</div>
                </div>

                <!-- Konten -->
                <div class="cert-title">This Certificate is Presented to</div>
                <div class="recipient">{{ $result->user->name }}</div>

                <div class="description">
                    For successfully participating in the assessment session:<br>
                    <span class="quiz-name">{{ $result->quiz->title }}</span><br>
                    Demonstrating commitment and professional competency in the evaluated subject.
                </div>

                <!-- Statistik Rapi -->
                <div class="stats-container">
                    <table class="stats-table">
                        <tr>
                            <td>
                                <div class="s-val">{{ number_format((float) $result->percentage, 1) }}%</div>
                                <div class="s-lbl">Final Score</div>
                            </td>
                            <td>
                                <div class="s-val">{{ $result->correct_answers }} / {{ $result->total_questions }}</div>
                                <div class="s-lbl">Accuracy</div>
                            </td>
                            <td>
                                <div class="s-val">{{ $result->formatted_completion_time }}</div>
                                <div class="s-lbl">Duration</div>
                            </td>
                            <td>
                                @if($result->is_passed)
                                    <span class="pass-badge">PASSED</span>
                                @else
                                    <span class="fail-badge">COMPLETED</span>
                                @endif
                                <div class="s-lbl" style="margin-top:8px;">Status</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Footer Tanda Tangan -->
                <table class="footer-table">
                    <tr>
                        <td valign="bottom" style="width: 60%;">
                            <div class="issue-date">
                                <strong>Date of Issue:</strong><br>
                                {{ $result->created_at->format('d F Y') }}
                            </div>
                        </td>
                        <td valign="bottom" align="right">
                            <div class="signature-area">
                                <div class="sign-line"></div>
                                <div class="sign-name">Admin Evaluasi</div>
                                <div class="sign-role">Assessment Director</div>
                            </div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>