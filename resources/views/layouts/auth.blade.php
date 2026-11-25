<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'Login') | Andhika.Dev</title>

    <meta
        name="robots"
        content="noindex, nofollow"
    >

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>

    <div class="auth-wrapper">

        <a href="{{ url('/') }}" class="auth-brand">
            Andhika<span>.</span>Dev
        </a>

        @yield('content')

    </div>

</body>

</html>
