@extends('emails.layouts.base')

@section('title', 'Verifikasi Email')

@section('content')
    <p>Halo {{ $name }},</p>

    <p>Terima kasih telah mendaftar di aplikasi KKL kami. Untuk melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini.</p>

    <div style="text-align: center;">
        <a href="{{ $verificationUrl }}" class="button">Verifikasi Email</a>
    </div>

    <p>Link verifikasi ini akan kadaluarsa dalam {{ $count }} menit.</p>

    <p>Jika Anda tidak membuat akun ini, Anda dapat mengabaikan email ini.</p>

    <div class="url-note">
        Jika Anda mengalami kesulitan mengklik tombol "Verifikasi Email", salin dan tempel URL berikut ke browser Anda:<br>
        <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
    </div>
@endsection
