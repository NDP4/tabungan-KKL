<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan KKL - {{ $month }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; }
        .summary { margin: 20px 0; padding: 10px; background: #f3f4f6; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
        .footer { margin-top: 30px; text-align: right; font-size: 0.9em; }
        .amount { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan KKL</h1>
        <h2>{{ $month }}</h2>
    </div>

    <div class="summary">
        <strong>Ringkasan:</strong><br>
        Total Setoran: Rp {{ number_format($total_savings, 0, ',', '.') }}<br>
        Total Pengeluaran: Rp {{ number_format($total_expenses, 0, ',', '.') }}<br>
        Saldo: Rp {{ number_format($total_savings - $total_expenses, 0, ',', '.') }}
    </div>

    <h3>Detail Setoran</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($savings as $saving)
            <tr>
                <td>{{ $saving->created_at->format('d/m/Y') }}</td>
                <td>{{ $saving->user->nim }}</td>
                <td>{{ $saving->user->name }}</td>
                <td class="amount">Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                <td>{{ $saving->payment_method === 'transfer' ? 'Transfer' : 'Tunai' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Detail Pengeluaran</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Dibuat Oleh</th>
                <th>Dikonfirmasi Oleh</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->created_at->format('d/m/Y') }}</td>
                <td>{{ $expense->description }}</td>
                <td>{{ $expense->creator->name }}</td>
                <td>{{ $expense->confirmedByUser->name }}</td>
                <td class="amount">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dibuat pada: {{ $generated_at }}
    </div>
</body>
</html>
