<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактировать комментарий</title>

    <!-- Подключаем Bootstrap CSS для стилизации -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <!-- Можно подключить дополнительные стили -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Навигационная панель (шапка) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Главная</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
           
        </div>
    </nav>

    <!-- Основной контент -->
    <div class="container">
        <h2>Редактировать комментарий</h2>
        
        <!-- Проверка наличия ошибки (если есть ошибка, выводим alert) -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Форма для редактирования комментария -->
        <form action="{{ route('comments.update', ['article' => $article->id, 'comment' => $comment->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="content">Комментарий</label>
                <textarea name="content" id="content" class="form-control" rows="4">{{ old('content', $comment->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Обновить комментарий</button>
            <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="btn btn-secondary mt-2">Отмена</a>
        </form>
    </div>

    <!-- Подвал страницы -->
    <footer class="bg-light text-center py-3 mt-5">
        <p>&copy; {{ date('Y') }} Все права защищены. Ваш сайт.</p>
    </footer>

    <!-- Подключаем jQuery и Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
