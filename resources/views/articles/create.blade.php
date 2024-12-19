<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать статью | EcoBin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav>
        <a href="{{ route('home') }}" class="nav-link">Главная</a>
            @if (auth()->check())
                <form method="POST" action="{{ route('logout') }}" class="nav-form">
                    @csrf
                    <button type="submit" class="nav-link">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Вход</a>
                <a href="{{ route('register') }}" class="nav-link">Регистрация</a>
            @endif
        </nav>
    </header>

    <div class="article-container">
        <div class="article-content">
            <h1>Создать новую статью</h1>
            
            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Содержание</label>
                    <textarea id="content" name="content" rows="6" class="form-control" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="poster">Изображение</label>
                    <input type="file" id="poster" name="poster" accept="image/*" required>
                </div>
                
                <button type="submit" class="button">Создать статью</button>

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