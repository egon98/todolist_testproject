<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f0f0f0;
            color: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .header {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .container {
            max-width: 800px;
            padding: 20px;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        .button:last-child {
            margin-right: 0;
        }
        .button:hover {
            background-color: #0056b3;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        p {
            font-size: 1rem;
            margin-top: 10px;
        }
    </style>
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
