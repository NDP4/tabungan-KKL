@extends('emails.layouts.base')

@section('title', 'Reset Password')

@section('content')
    <p>Halo {{ $name }},</p>

    <p>Kami menerima permintaan untuk mengatur ulang password akun Anda. Silakan klik tombol di bawah ini untuk melanjutkan proses reset password.</p>

    <div style="text-align: center;">
        <a href="{{ $resetUrl }}" class="button">Reset Password</a>
    </div>

    <p>Link reset password ini akan kadaluarsa dalam {{ $count }} menit.</p>

    <p>Jika Anda tidak merasa mengajukan permintaan reset password, Anda dapat mengabaikan email ini.</p>

    <div class="url-note">
        Jika Anda mengalami kesulitan mengklik tombol "Reset Password", salin dan tempel URL berikut ke browser Anda:<br>
        <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
    </div>
@endsection
