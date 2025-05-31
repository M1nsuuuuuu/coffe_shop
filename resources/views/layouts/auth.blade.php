<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кофейня - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=JejuGothic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body class="auth-body" style="background-image: url('{{ asset('images/auth-bg.jpg') }}');">
    <div class="auth-container">
        <a href="{{ url()->previous() }}" class="close-btn">&times;</a>
        
        <div class="auth-content">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>