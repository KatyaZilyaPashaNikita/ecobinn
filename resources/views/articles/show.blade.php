<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<style>
/* Общие стили для кнопок */
.button {
    padding: 10px 20px;
    font-size: 16px;
    
}

.delete {
    background-color: #f44336; /* Красный для удаления */
    color: white;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    width: 150px; /* Устанавливаем одинаковую ширину для всех кнопок */
    height: 45px; 
    transition: background-color 0.3s ease;
    text-align: center;
}

.btn-success {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    width: 200px;
    height: 45px; 
    background-color: #5DAD60; /* Зеленый для восстановления */
    color: white;
}

.btn-warning {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    width: 200px;
    height: 45px; 
    background-color: #5DAD60; /* Оранжевый для скрытия */
    color: white;
}

/* Стили для кнопок при наведении */
.button:hover {
    opacity: 0.8;
}

/* Стили для выравнивания кнопок в статье */
.article-actions {
    display: flex;
    justify-content: space-between; /* Разделяем кнопки на две стороны */
    margin-top: 10px;
}

.article-actions .left-actions {
    display: flex;
    justify-content: flex-start; /* Кнопка удаления слева */
}

.article-actions .right-actions {
    display: flex;
    justify-content: flex-end; /* Кнопка скрытия/восстановления справа */
    gap: 10px; /* Расстояние между кнопками */
}

    </style>
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

<div class="article-container">
    <article class="article-content">
        <h1>{{ $article->title }}</h1>
        @if($article->hasMedia('images'))
            <div class="article-image">
                <img src="{{ $article->getFirstMediaUrl('images') }}" alt="{{ $article->title }}">
            </div>
        @endif
        
        <div class="article-text">
            {{ $article->content }}
        </div>

        @if(auth()->id() === $article->user_id)
            <div class="article-actions">
                <!-- Кнопка удаления слева -->
                <div class="left-actions">
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button delete">Удалить</button>
                    </form>
                </div>

                <!-- Кнопка скрытия/восстановления справа (для администратора) -->
                <div class="right-actions">
                    @if(auth()->check() && auth()->user()->is_admin)
                        @if($article->is_hidden)
                            <!-- Если статья скрыта, показать кнопку восстановления -->
                            <form action="{{ route('articles.restore', $article->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-success">Восстановить статью</button>
                            </form>
                        @else
                            <!-- Если статья не скрыта, показать кнопку скрытия -->
                            <form action="{{ route('articles.hide', $article->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-warning">Скрыть статью</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </article>
</div>
        <section class="comments-section">
            <h2>Комментарии</h2>

            @auth
                <form action="{{ route('comments.store', $article) }}" method="POST" class="comment-form">
                    @csrf
                    <textarea name="content" rows="3" placeholder="Оставьте комментарий..." required></textarea>
                    <button type="submit" class="button">Отправить</button>
                </form>
            @else
                <p class="login-prompt">Пожалуйста <a href="{{ route('login') }}">войдите</a> чтобы комментировать.</p>
            @endauth

            <div class="comments-list">
    @foreach($article->comments()->with('user')->latest()->get() as $comment)
        <div class="comment">
            <p>{{ $comment->content }}</p>
            <small>Автор: {{ $comment->user->name }}</small>

            <div class="comment-actions mt-2 d-flex justify-content-start gap-2">
                <!-- Ссылка для редактирования, если комментарий принадлежит текущему пользователю -->
                @if($comment->user_id === auth()->id())
                    <a href="{{ route('comments.edit', ['article' => $article->id, 'comment' => $comment->id]) }}" class="btn btn-warning btn-sm">Редактировать</a>
                @endif
                
                @if(auth()->user() && auth()->user()->is_admin)
                    <a href="{{ route('comments.destroy', $comment->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить этот комментарий?')">Удалить</a>
                @endif
            </div>
        </div>
    @endforeach
</div>

        </section>
    </div>




    <footer>
        <div class="footer-logo">EcoBin</div>
    
    </footer>
</body>
</html>
