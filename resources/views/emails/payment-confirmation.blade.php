@component('mail::message')
# Konfirmasi Pembayaran KKL

Hai {{ $saving->creator->name }},

Terima kasih atas setoran KKL anda sebesar **Rp {{ number_format($saving->amount, 0, ',', '.') }}**.

Total setoran anda saat ini: **Rp {{ number_format($totalSavings, 0, ',', '.') }}**
Progress: **{{ number_format($progress, 1) }}%**

@component('mail::button', ['url' => url('/dashboard')])
Lihat Detail
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
