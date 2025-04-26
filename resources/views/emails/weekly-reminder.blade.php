@component('mail::message')
# Pengingat Setoran KKL Mingguan

Hai {{ $user->name }},

Minggu ini kamu belum mencapai target setoran mingguan KKL sebesar **Rp {{ number_format($targetAmount, 0, ',', '.') }}**.

Status setoran mingguan kamu:
- Target: **Rp {{ number_format($targetAmount, 0, ',', '.') }}**
- Sudah disetor: **Rp {{ number_format($currentAmount, 0, ',', '.') }}**
- Sisa yang perlu disetor: **Rp {{ number_format($targetAmount - $currentAmount, 0, ',', '.') }}**

@component('mail::button', ['url' => route('dashboard')])
Setor Sekarang
@endcomponent

Yuk segera setor untuk mencapai target KKL kita!

Salam,<br>
Tim Bendahara KKL
@endcomponent
