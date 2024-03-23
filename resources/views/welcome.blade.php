<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
<div class="header">
    <a href="{{ route('login') }}" class="button">Bejelentkezés</a>
    <a href="{{ route('register') }}" class="button">Regisztráció</a>
</div>
<div class="container">
    <h1>Todo Alkalmazás</h1>
    @if (Route::has('login'))
        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="button">Dashboard</a>
            @endauth
        </div>
    @endif
</div>
</body>
</html>
