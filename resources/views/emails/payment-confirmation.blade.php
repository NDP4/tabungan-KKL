@extends('emails.layouts.base')

@section('title', 'Menabung KKL Disetujui')

@section('content')
    <p>Hai {{ $saving->user->name }},</p>

    <div class="info-box">
        <p class="amount">kamu telah menabung Rp {{ number_format($saving->amount, 0, ',', '.') }}</p>
        <p>Menabung KKL Anda telah disetujui oleh {{ $saving->confirmedByUser->name }}</p>

        <div class="mt-4">
            <p class="mb-2 text-sm text-gray-600">Progress Tabungan KKL:</p>
            <div class="progress-container">
                <div class="progress-bar" style="width: {{ min($progress, 100) }}%"></div>
            </div>
            <p class="mt-2">Total Tabungan: Rp {{ number_format($totalSavings, 0, ',', '.') }}</p>
            <p>Progress: {{ number_format($progress, 1) }}%</p>
        </div>
    </div>

    <p>Terima kasih atas kontribusi Anda dalam mencapai target KKL!</p>

    <div style="text-align: center;">
        <a href="{{ route('dashboard') }}" class="button">Lihat Detail Tabungan</a>
    </div>
@endsection
