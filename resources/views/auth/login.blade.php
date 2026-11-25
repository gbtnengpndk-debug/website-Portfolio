@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')

<div class="auth-card">

    <h1>Masuk ke Admin</h1>

    <p class="auth-subtitle">
        Kelola project, skill, dan pesan portfolio kamu.
    </p>

    @if (session('status'))
        <div class="auth-alert auth-alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="auth-alert auth-alert-error">
            <strong>Gagal masuk:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">

        @csrf

        <div class="auth-group">

            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                required
                autofocus
                autocomplete="username"
            >

        </div>

        <div class="auth-group">

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
                autocomplete="current-password"
            >

        </div>

        <div class="auth-row">

            <label class="auth-checkbox" for="remember_me">

                <input
                    type="checkbox"
                    id="remember_me"
                    name="remember"
                >

                Ingat saya

            </label>

            @if (Route::has('password.request'))
                <a
                    class="auth-link"
                    href="{{ route('password.request') }}"
                >
                    Lupa password?
                </a>
            @endif

        </div>

        <button type="submit" class="auth-button">
            Masuk
        </button>

    </form>

    <p class="auth-footer">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar</a>
    </p>

</div>

<p class="auth-back">
    <a href="{{ url('/') }}">← Kembali ke portfolio</a>
</p>

@endsection
