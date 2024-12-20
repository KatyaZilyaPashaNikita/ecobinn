<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=K2D:wght@400;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Posts</title>
</head>

<body>
    <header>
    <nav>
        @if (Auth::check())
        <a href="{{ route('logout') }}" class="nav-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Выйти
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
        @else
        <a href="{{ route('login') }}" class="nav-link">Вход</a>
        <a href="{{ route('register') }}" class="nav-link">Регистрация</a>
            @if (Auth::user()->is_admin)
            <a href="{{ route('articles.create') }}" class="nav-link">Создать статью</a>
            @endif
        @endif
        <a href="{{ route('map') }}" class="nav-link">Карта</a>
    </nav>
    </header>
</body>

</html>