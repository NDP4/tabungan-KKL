<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran KKL</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --border-color: #e2e8f0;
            --success-color: #22c55e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            color: #0f172a;
            background: #ffffff;
            padding: 1.5cm;
            font-size: 9pt;
        }

        .invoice-container {
            position: relative;
            max-width: 21cm; /* A4 width */
            margin: 0 auto;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1);
            background: #ffffff;
        }

        .invoice-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo {
            width: 48px;
            height: auto;
        }

        .organization-info {
            text-align: right;
        }

        .invoice-title {
            font-size: 16px;
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .invoice-number {
            color: var(--secondary-color);
            font-size: 0.75rem;
        }

        .invoice-body {
            padding: 1rem;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .info-table th {
            text-align: left;
            padding: 0.5rem 0.75rem;
            background-color: #f8fafc;
            border: 1px solid var(--border-color);
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--secondary-color);
            letter-spacing: 0.05em;
        }

        .info-table td {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            font-size: 0.8rem;
            color: #1e293b;
        }

        .payment-details {
            background-color: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            padding: 1rem;
            margin: 1.5rem 0;
            text-align: center;
        }

        .amount-display {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .payment-method {
            color: var(--secondary-color);
            font-size: 0.75rem;
        }

        .thank-you-note {
            text-align: center;
            margin: 1.5rem 0;
            font-size: 0.75rem;
            color: var(--secondary-color);
        }

        .signatures {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            gap: 1.5rem;
            padding: 0 1rem;
        }

        .signature-box {
            flex: 1;
            text-align: center;
        }

        .signature-line {
            width: 100%;
            max-width: 160px;
            margin: 0 auto 0.5rem;
            min-height: 48px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .signature-line img {
            max-width: 120px;
            max-height: 48px;
        }

        .signature-name {
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.125rem;
        }

        .signature-title {
            font-size: 0.7rem;
            color: var(--secondary-color);
        }

        .stamp {
            position: absolute;
            bottom: 25%;
            right: 8%;
            transform: rotate(-15deg);
            font-size: 2.5rem;
            font-weight: bold;
            color: rgba(34, 197, 94, 0.2);
            text-transform: uppercase;
            pointer-events: none;
            border: 0.25rem double rgba(34, 197, 94, 0.2);
            padding: 0.25rem 0.75rem;
        }

        .invoice-footer {
            padding: 1rem;
            background-color: #f8fafc;
            border-top: 1px solid var(--border-color);
            font-size: 0.7rem;
            color: var(--secondary-color);
            text-align: center;
        }

        .footer-info {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        @page {
            size: A4;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="logo-container">
                @if(settings('site_logo'))
                    <img src="{{ storage_path('app/public/' . settings('site_logo')) }}" class="logo" alt="Logo">
                @endif
                <div>
                    <h1 class="invoice-title">{{ settings('site_name', 'KKL') }}</h1>
                </div>
            </div>
            <div class="organization-info">
                <h2 class="invoice-title">Bukti Pembayaran</h2>
                <p class="invoice-number">No. KKL-{{ str_pad($saving->id, 5, '0', STR_PAD_LEFT) }}/{{ $saving->created_at->format('Y') }}</p>
            </div>
        </div>

        <div class="invoice-body">
            <table class="info-table">
                <tr>
                    <th colspan="2">Informasi Pembayaran</th>
                </tr>
                <tr>
                    <td style="width: 30%">Nama Penyetor</td>
                    <td>{{ $saving->user->name }}</td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>{{ $saving->user->nim }}</td>
                </tr>
                <tr>
                    <td>Setoran Ke</td>
                    <td>#{{ $saving->sequence_number }}</td>
                </tr>
                <tr>
                    <td>Tanggal & Waktu</td>
                    <td>{{ $saving->created_at->translatedFormat('l, d F Y') }} · {{ $saving->created_at->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td>{{ ucfirst($saving->payment_method) }}</td>
                </tr>
            </table>

            <div class="payment-details">
                <div class="amount-display">
                    Rp {{ number_format($saving->amount, 0, ',', '.') }}
                </div>
                <div class="payment-method">
                    Pembayaran via {{ ucfirst($saving->payment_method) }}
                </div>
            </div>

            <div class="thank-you-note">
                <p>Terima kasih atas kontribusi Anda dalam program tabungan KKL.</p>
                <p>Semoga dengan semangat menabung ini, kita dapat mewujudkan KKL yang berkualitas.</p>
            </div>

            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-line">
                        <hr style="width: 100%; border-top: 1px solid #e2e8f0;">
                    </div>
                    <p class="signature-name">{{ $saving->user->name }}</p>
                    <p class="signature-title">Penyetor</p>
                </div>
                <div class="signature-box">
                    <div class="signature-line">
                        @if(settings('treasurer_signature'))
                            <img src="{{ storage_path('app/public/' . settings('treasurer_signature')) }}"
                                 alt="Tanda Tangan Bendahara">
                        @endif
                    </div>
                    <p class="signature-name">{{ settings('treasurer_name', 'Bendahara') }}</p>
                    <p class="signature-title">Bendahara KKL</p>
                </div>
            </div>
        </div>

        <div class="invoice-footer">
            <div class="footer-info">
                @if(settings('site_address'))
                    <span>{{ settings('site_address') }}</span>
                @endif
                @if(settings('site_phone'))
                    <span>{{ settings('site_phone') }}</span>
                @endif
                @if(settings('site_email'))
                    <span>{{ settings('site_email') }}</span>
                @endif
            </div>
        </div>

        @if($saving->status === 'approved')
            <div class="stamp">Lunas</div>
        @endif
    </div>
</body>
</html>
