@extends('layouts.auth')

@section('title', 'Daftar Akun')

@section('content')

<div class="auth-card">

    <h1>Daftar Akun</h1>

    <p class="auth-subtitle">
        Buat akun untuk mengakses halaman admin portfolio.
    </p>

    @if ($errors->any())
        <div class="auth-alert auth-alert-error">
            <strong>Terjadi kesalahan:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">

        @csrf

        <div class="auth-group">

            <label for="name">Nama</label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Nama lengkap"
                required
                autofocus
                autocomplete="name"
            >

        </div>

        <div class="auth-group">

            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                required
                autocomplete="username"
            >

        </div>

        <div class="auth-group">

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimal 8 karakter"
                required
                autocomplete="new-password"
            >

        </div>

        <div class="auth-group">

            <label for="password_confirmation">Konfirmasi Password</label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Ulangi password"
                required
                autocomplete="new-password"
            >

        </div>

        <button type="submit" class="auth-button">
            Daftar
        </button>

    </form>

    <p class="auth-footer">
        Sudah punya akun?
        <a href="{{ route('login') }}">Masuk</a>
    </p>

</div>

<p class="auth-back">
    <a href="{{ url('/') }}">← Kembali ke portfolio</a>
</p>

@endsection
