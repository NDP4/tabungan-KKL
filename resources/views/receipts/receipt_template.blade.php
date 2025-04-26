<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');

        :root {
            --font-color: black;
            --highlight-color: #00a5ce;
            --header-bg-color: #B8E6F1;
            --footer-bg-color: #BFC0C3;
        }

        @page {
            size: A4;
            margin: 4cm 0 3cm 0;
        }

        body {
            margin: 0;
            padding: 1cm 2cm;
            color: var(--font-color);
            font-family: 'Montserrat', sans-serif;
            font-size: 10pt;
        }

        header {
            height: 4cm;
            padding: 0 2cm;
            background-color: var(--header-bg-color);
            position: running(header);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }

        .logo-section {
            display: flex;
            align-items: center;
        }

        .logo-section img {
            width: 1.5cm;
            height: auto;
            margin-right: 0.5cm;
        }

        .receipt-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .receipt-number {
            font-size: 14px;
            margin-top: 5px;
        }

        .details {
            margin-top: 1cm;
        }

        .details-row {
            display: flex;
            margin-bottom: 0.5cm;
        }

        .label {
            width: 200px;
            font-weight: bold;
            color: var(--highlight-color);
        }

        .value {
            flex: 1;
        }

        footer {
            height: 3cm;
            padding: 0 2cm;
            background-color: var(--footer-bg-color);
            position: running(footer);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 8pt;
        }

        hr {
            margin: 0.8cm 0;
            height: 0;
            border: 0;
            border-top: 1mm solid var(--highlight-color);
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-section">
                @if(settings('site_logo'))
                    <img src="{{ storage_path('app/public/' . settings('site_logo')) }}" alt="Logo">
                @endif
                <h1>{{ settings('site_name', 'KKL System') }}</h1>
            </div>
            <div>
                <div class="receipt-title">Bukti Pembayaran</div>
                <div class="receipt-number">No. KKL-{{ str_pad($saving->id, 5, '0', STR_PAD_LEFT) }}/{{ $saving->created_at->format('Y') }}</div>
            </div>
        </div>
    </header>

    <main>
        <div class="details">
            <div class="details-row">
                <span class="label">Telah diterima dari</span>
                <span class="value">{{ $saving->user->name }} ({{ $saving->user->nim }})</span>
            </div>
            <div class="details-row">
                <span class="label">Tanggal</span>
                <span class="value">{{ $saving->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="details-row">
                <span class="label">Jumlah</span>
                <span class="value">Rp {{ number_format($saving->amount, 0, ',', '.') }}</span>
            </div>
            <div class="details-row">
                <span class="label">Metode Pembayaran</span>
                <span class="value">{{ $saving->payment_method }}</span>
            </div>
            <div class="details-row">
                <span class="label">Status</span>
                <span class="value">{{ $saving->status }}</span>
            </div>
        </div>

        <hr>

        <div style="margin-top: 1cm;">
            <div style="float: right; text-align: center;">
                <div style="margin-bottom: 2cm;">
                    {{ $saving->created_at->format('d F Y') }}
                </div>
                <div>
                    _____________________<br>
                    Petugas
                </div>
            </div>
        </div>
    </main>

    <footer>
        <span>{{ settings('site_address', 'Alamat KKL') }}</span>
        <span>{{ settings('site_phone', 'Telepon KKL') }}</span>
        <span>{{ settings('site_email', 'Email KKL') }}</span>
    </footer>
</body>
</html>
