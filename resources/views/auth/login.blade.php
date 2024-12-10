<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | EcoBin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('home') }}" class="nav-link">Главная</a>
            <a href="{{ route('register') }}" class="nav-link">Регистрация</a>
        </nav>
    </header>

    <div class="auth-container">
        <div class="auth-card">
            <h1>Вход в систему</h1>
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <button type="submit" class="button">Войти</button>
                
                @if ($errors->any())
                    <div class="auth-errors">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-logo">EcoBin</div>
    </footer>
</body>
</html>