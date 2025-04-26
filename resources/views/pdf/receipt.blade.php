<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran KKL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .receipt-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .receipt-number {
            color: #666;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 30px;
        }
        .details-row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }
        .amount {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-left: auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="receipt-title">BUKTI PEMBAYARAN KKL</div>
        <div class="receipt-number">No: KKL-{{ str_pad($saving->id, 5, '0', STR_PAD_LEFT) }}</div>
    </div>

    <div class="details">
        <div class="details-row">
            <span class="label">Nama:</span>
            <span>{{ $saving->user->name }}</span>
        </div>
        <div class="details-row">
            <span class="label">NIM:</span>
            <span>{{ $saving->user->nim }}</span>
        </div>
        <div class="details-row">
            <span class="label">Tanggal:</span>
            <span>{{ $saving->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="details-row">
            <span class="label">Minggu Ke:</span>
            <span>{{ $saving->week_number }}</span>
        </div>
        <div class="details-row">
            <span class="label">Metode Pembayaran:</span>
            <span>{{ $saving->payment_method === 'transfer' ? 'Transfer Bank' : 'Tunai' }}</span>
        </div>
    </div>

    <div class="amount">
        Jumlah: Rp {{ number_format($saving->amount, 0, ',', '.') }}
    </div>

    <div class="footer">
        <div>Semarang, {{ now()->format('d/m/Y') }}</div>
        <div>Bendahara KKL</div>
        <div class="signature-line"></div>
        <div>(Nama Bendahara)</div>
    </div>
</body>
</html>
