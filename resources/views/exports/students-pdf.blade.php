<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
            page-break-inside: auto;
        }
        .table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 9pt;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 10px;
            font-size: 8pt;
            text-align: right;
            border-top: 1px solid #eee;
        }
        .page-break {
            page-break-after: always;
        }
        .text-right {
            text-align: right;
        }
        .bg-warning {
            background-color: #fff3cd;
        }
        .bg-success {
            background-color: #d4edda;
        }
        @page {
            margin: 100px 25px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0;">Rekap Data Mahasiswa KKL</h2>
        <p style="margin: 5px 0 0;">{{ $generated_at }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 15%;">NIM</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;">Total Setoran</th>
                <th style="width: 10%;">Progress</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student['nim'] }}</td>
                    <td>{{ $student['name'] }}</td>
                    <td>{{ $student['email'] }}</td>
                    <td class="text-right">Rp {{ number_format($student['total_savings'], 0, ',', '.') }}</td>
                    <td class="text-right {{ $student['progress'] >= 100 ? 'bg-success' : ($student['progress'] < 50 ? 'bg-warning' : '') }}">
                        {{ number_format($student['progress'], 1) }}%
                    </td>
                    <td>{{ $student['email_verified'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $generated_at }}
        <span style="float: right;">Halaman {PAGENO}</span>
    </div>
</body>
</html>
