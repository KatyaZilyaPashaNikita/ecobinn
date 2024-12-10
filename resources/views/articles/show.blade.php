<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav>
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
        <article class="article-content">
            <h1>{{ $article->title }}</h1>
            
            @if($article->hasMedia('posters'))
                <div class="article-image">
                    <img src="{{ $article->getFirstMediaUrl('posters') }}" alt="{{ $article->title }}">
                </div>
            @endif
            
            <div class="article-text">
                {{ $article->content }}
            </div>

            @if(auth()->id() === $article->user_id)
                <div class="article-actions">
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button delete">Удалить</button>
                    </form>
                </div>
            @endif
        </article>

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
                        <div class="comment-author">{{ $comment->user->name }}</div>
                        <div class="comment-content">{{ $comment->content }}</div>
                        <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
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