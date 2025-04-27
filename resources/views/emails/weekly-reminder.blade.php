@extends('emails.layouts.base')

@section('title', 'Pengingat Setoran KKL Minggu Ini')

@section('content')
    <p>Hai {{ $notifiable->name }},</p>

    <p>Minggu ini Anda belum mencapai target setoran mingguan KKL.</p>

    <div class="info-box">
        <p class="amount">Target: Rp {{ number_format($targetAmount, 0, ',', '.') }}</p>
        <p class="amount">Sudah disetor: Rp {{ number_format($currentAmount, 0, ',', '.') }}</p>

        <div class="progress-container">
            <div class="progress-bar" style="width: {{ min(($currentAmount / $targetAmount) * 100, 100) }}%"></div>
        </div>
    </div>

    <p>Yuk, segera lakukan setoran agar target KKL Anda tercapai tepat waktu!</p>

    <div style="text-align: center;">
        <a href="{{ route('savings.create') }}" class="button">Setor Sekarang</a>
    </div>
@endsection
