<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактировать комментарий</title>

    <style>
        /* Основные стили */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Контейнер для контента */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px #555;
            border-radius: 8px;
            border-color: #5DAD60;
        }

        /* Заголовки */
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Формы */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        textarea {
            width: 100%;
            padding: 9px;
            font-size: 14px;
            border: 2px solid #5DAD60;
            border-radius: 2px;
            resize: vertical;
        }

        /* Кнопки */
        button, .btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            border: none;
        }

        /* Стиль кнопки отправки */
        .btn-primary {
            background-color: #5DAD60;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #5DAD60;
        }

        /* Стиль кнопки отмены */
        .btn-secondary {
            background-color:rgb(140, 140, 140);
            color: #fff;
        }

        .btn-secondary:hover {
            background-color:rgb(143, 147, 151);
        }

        /* Сообщения об ошибках */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
        }

        /* Подвал */
        footer {
            background-color: #5DAD60;
            text-align: center;
            padding: 15px;
            margin-top: 30px;
            font-size: 14px;
            color: #333;
        }

        footer p {
            margin: 0;
        }
        header {
    background: linear-gradient(135deg, #5DAD60 0%, #7bc97e 100%);
    padding: 1rem;
}
        nav {
    display: flex;
    justify-content: flex-end;
    margin-left: 1rem;
}
.nav-links {
    color: #5DAD60; /* Ваш цвет */
    margin-left: 86px;
    font-size: 18px; 
}
.nav-form button {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #000;
    text-decoration: none;
    margin-left: 1rem;
    font-family: inherit;
    font-size: inherit;
}

.nav-link {
    color: #FFF;
    text-decoration: none;
    margin-left: 3rem;
}

.nav-form {
    margin: 0;
}
    </style>
</head>
<body>
<header>
        <nav>
            @if (auth()->check())
                <form method="POST" action="{{ route('logout') }}" class="nav-form">
                    @csrf
                    <a href="{{ route('home') }}" class="nav-link">Главная</a>
                    <button type="submit" class="nav-link">Выйти</button>
                </form>
            @else
            <a href="{{ route('home') }}" class="nav-link">Главная</a>
                <a href="{{ route('login') }}" class="nav-link">Вход</a>
                <a href="{{ route('register') }}" class="nav-link">Регистрация</a>
            @endif
        </nav>
    </header>

    <!-- Основной контент -->
    <div class="container">
        <h2>Редактировать комментарий</h2>
        
        <!-- Проверка наличия ошибки (если есть ошибка, выводим alert) -->
        @if(session('error'))
            <div class="alert">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Форма для редактирования комментария -->
        <form action="{{ route('comments.update', ['article' => $article->id, 'comment' => $comment->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="content">Комментарий</label>
                <textarea name="content" id="content" rows="4">{{ old('content', $comment->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Обновить комментарий</button>
            <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>

  
</body>
</html>
