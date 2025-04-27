<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; }
        .table { width: 100%; border-collapse: collapse; margin-top: 1em; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f8f9fa; }
        .header { text-align: center; margin-bottom: 2em; }
        .footer { margin-top: 2em; font-size: 0.8em; text-align: right; }
        .total { margin-top: 1em; text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Rekap Setoran KKL</h2>
        <p>{{ $generated_at }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Minggu Ke</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($savings as $saving)
                <tr>
                    <td>{{ $saving->created_at->format('d/m/Y') }}</td>
                    <td>{{ $saving->user->nim }}</td>
                    <td>{{ $saving->user->name }}</td>
                    <td>Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                    <td>{{ $saving->week_number }}</td>
                    <td>{{ $saving->payment_method }}</td>
                    <td>{{ $saving->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Setoran: Rp {{ number_format($total, 0, ',', '.') }}
    </div>

    <div class="footer">
        Dicetak pada: {{ $generated_at }}
    </div>
</body>
</html>
