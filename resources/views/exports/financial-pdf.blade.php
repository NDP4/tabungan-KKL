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
        .summary-box {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        @page {
            margin: 100px 25px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0;">Laporan Keuangan KKL</h2>
        <p style="margin: 5px 0 0;">{{ $generated_at }}</p>
    </div>

    <div class="summary-box">
        <table width="100%">
            <tr>
                <td>Total Pemasukan:</td>
                <td class="text-right">Rp {{ number_format($total_savings, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pengeluaran:</td>
                <td class="text-right">Rp {{ number_format($total_expenses, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td>Saldo:</td>
                <td class="text-right">Rp {{ number_format($balance, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <h3>Daftar Pemasukan</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Dikonfirmasi Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($savings as $saving)
                <tr>
                    <td>{{ $saving->created_at->format('d/m/Y') }}</td>
                    <td>{{ $saving->user->nim }}</td>
                    <td>{{ $saving->user->name }}</td>
                    <td class="text-right">Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                    <td>{{ $saving->payment_method }}</td>
                    <td>{{ $saving->confirmedByUser?->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <h3>Daftar Pengeluaran</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Dibuat Oleh</th>
                <th>Dikonfirmasi Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->created_at->format('d/m/Y') }}</td>
                    <td>{{ $expense->description }}</td>
                    <td class="text-right">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                    <td>{{ $expense->creator->name }}</td>
                    <td>{{ $expense->confirmedByUser?->name ?? '-' }}</td>
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
