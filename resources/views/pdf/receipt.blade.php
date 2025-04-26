<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran KKL</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
            background: #fff;
        }
        .container {
            position: relative;
            background: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3182ce;
        }
        .receipt-title {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 10px;
        }
        .receipt-number {
            color: #4a5568;
            font-size: 14px;
        }
        .logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100px;
            height: auto;
        }
        .details {
            margin-bottom: 40px;
            padding: 20px;
            background: #f7fafc;
            border-radius: 8px;
        }
        .details-row {
            display: flex;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .label {
            font-weight: bold;
            color: #4a5568;
            width: 180px;
        }
        .value {
            color: #2d3748;
            flex: 1;
        }
        .amount-section {
            margin: 30px 0;
            padding: 20px;
            background: #ebf8ff;
            border-radius: 8px;
            text-align: center;
        }
        .amount-label {
            font-size: 16px;
            color: #2c5282;
            margin-bottom: 5px;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #2b6cb0;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            color: #4a5568;
        }
        .signature-section {
            margin-top: 20px;
            text-align: right;
        }
        .signature {
            width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
        .treasurer-name {
            font-weight: bold;
            margin-top: 10px;
            color: #2d3748;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(203, 213, 224, 0.3);
            z-index: -1;
        }
        .status-approved {
            position: absolute;
            top: 50%;
            right: 30px;
            transform: rotate(-15deg);
            font-size: 48px;
            color: rgba(72, 187, 120, 0.5);
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        @if(settings('site_logo'))
            <img src="{{ storage_path('app/public/' . settings('site_logo')) }}" class="logo" alt="Logo">
        @endif

        <div class="header">
            <div class="receipt-title">BUKTI PEMBAYARAN KKL</div>
            <div class="receipt-number">No: KKL-{{ str_pad($saving->id, 5, '0', STR_PAD_LEFT) }}/{{ $saving->created_at->format('Y') }}</div>
        </div>

        <div class="details">
            <div class="details-row">
                <span class="label">Telah diterima dari</span>
                <span class="value">{{ $saving->user->name }} ({{ $saving->user->nim }})</span>
            </div>
            <div class="details-row">
                <span class="label">Setoran Ke</span>
                <span class="value">#{{ $saving->sequence_number }}</span>
            </div>
            <div class="details-row">
                <span class="label">Tanggal</span>
                <span class="value">{{ $saving->created_at->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="details-row">
                <span class="label">Waktu</span>
                <span class="value">{{ $saving->created_at->format('H:i') }} WIB</span>
            </div>
            <div class="details-row">
                <span class="label">Metode Pembayaran</span>
                <span class="value">{{ $saving->payment_method === 'transfer' ? 'Transfer Bank' : 'Tunai' }}</span>
            </div>
            @if($saving->notes)
            <div class="details-row">
                <span class="label">Catatan</span>
                <span class="value">{{ $saving->notes }}</span>
            </div>
            @endif
        </div>

        <div class="amount-section">
            <div class="amount-label">Jumlah Setoran</div>
            <div class="amount">Rp {{ number_format($saving->amount, 0, ',', '.') }}</div>
        </div>

        <div class="footer">
            <div>Semarang, {{ $saving->updated_at->translatedFormat('d F Y') }}</div>
            <div class="signature-section">
                @if(settings('treasurer_signature'))
                    <img src="{{ storage_path('app/public/' . settings('treasurer_signature')) }}" class="signature" alt="Tanda Tangan Bendahara">
                @endif
                <div class="treasurer-name">{{ settings('treasurer_name', 'Nama Bendahara') }}</div>
                <div>Bendahara KKL</div>
            </div>
        </div>

        <div class="watermark">{{ settings('site_name', 'KKL') }}</div>

        @if($saving->status === 'approved')
            <div class="status-approved">Lunas</div>
        @endif
    </div>
</body>
</html>
