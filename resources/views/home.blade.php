<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoBin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=K2D:wght@400;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            @if ($isLoggedIn)
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
            @endif
            @if ($isAdmin)
                <a href="{{ route('articles.create') }}" class="nav-link">Создать статью</a>
            @endif
            <a href="{{ route('map') }}" class="nav-link">Карта</a>
            <a href="{{ route('book') }}" class="nav-link">Справочник</a>
        </nav>
    </header>

    <section class="promo-header">
        <div class="promo-wrapper">
            <div class="promo-content">
                <h1>EcoBin</h1>
                <p class="subtitle">Сортируй сегодня - чистая планета завтра!</p>
            </div>
            <div class="promo-image">
                <img src="{{ asset('static/Group 38.png') }}" alt="Promo">
            </div>
        </div>
    </section>

    <section class="impact">
        <h2 class="section-title">Мусор оказывает значительное влияние на окружающую среду и здоровье человека</h2>
        <div class="cards-row">
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r11.png') }}" alt="Image 1">
                </div>
                <div class="divider"></div>
                <p>Площадь мусорных полтигонов в России превышает 4 миллиона гектаров, что сопоставимо с территорией Швейцарии</p>
            </div>
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r12.png') }}" alt="Image 2">
                </div>
                <div class="divider"></div>
                <p>100 000 морских животных и 1 000 000 птиц погибают от пластика каждый год</p>
            </div>
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r13.png') }}" alt="Image 3">
                </div>
                <div class="divider"></div>
                <p>Ежедневно покупая любимые напитки в бумажных стаканчиках, один человек производит 10 кг мусора в год</p>
            </div>
        </div>
    </section>

    <div class="section-title">
        <p>Переработка мусора - это не только способ помочь природе, но и шанс создать что-то новое из того, что казалось ненужным</p>
    </div>

    <section class="articles">
        <div class="articles-grid">
            @foreach ($articles as $article)
                <div class="article-card">
                <div class="article-poster">
    @if($article->hasMedia('posters'))
        <img src="{{ $article->getFirstMediaUrl('posters') }}" alt="{{ $article->title }}">
    @endif
</div>
                    <h3><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h3>
                </div>
            @endforeach
        </div>
        {{ $articles->links() }}
        <a href="{{ route('articles.index') }}" class="btn btn-primary">Все статьи</a>
    </section>

    <section class="recycling-benefits">
        <h2 class="section-title">Переработка мусора помогает сэкономить ресурсы</h2>
        <div class="cards-row">
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r21.png') }}" alt="Image 1">
                </div>
                <div class="divider"></div>
                <p>60 кг сданной на переработку макулатуры заменяют одно дерево</p>
            </div>
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r22.png') }}" alt="Image 2">
                </div>
                <div class="divider"></div>
                <p>Переработка 125 алюминиевых банок экономит достаточно энергии, чтобы питать 1 дом целый день</p>
            </div>
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r23.png') }}" alt="Image 3">
                </div>
                <div class="divider"></div>
                <p>Энергии, которая тратится на производство одной бутылки достаточно для переработки 10 бутылок</p>
            </div>
        </div>
    </section>

    <section class="myths">
    <h2 class="section-title">Мифы о переработке мусора</h2>
    <div class="myths-grid">
        <div class="myth-card" data-myth="Переработать можно только мусор из одного материала" data-reality="Современные машины позволяют разделять некоторые предметы на составные части, а производители упаковок стремятся сделать продукцию максимально пригодной для переработки">
            <p class="myth-text">Переработать можно только мусор из одного материала</p>
        </div>
        <div class="myth-card" data-myth="Переработать мусор можно только один раз" data-reality="Металлы и стекло можно перерабатывать бесконечно без потери качества. Бумагу — до семи раз, но при этом волокна истончаются, снижая качество.">
            <p class="myth-text">Переработать мусор можно только один раз</p>
        </div>
        <div class="myth-card" data-myth="Переработка отходов требует больше энергии, чем производство нового продукта из первичного сырья" data-reality="Специалисты разработали способы, которые экономят при переработке вторсырья энергию, воду и воздух">
            <p class="myth-text">Переработка отходов требует больше энергии, чем производство нового продукта из первичного сырья</p>
        </div>
        <div class="myth-card" data-myth="Изделия из вторичного сырья — некачественные" data-reality="Современные стандарты качества и гигиенические требования к потребительским изделиям не позволяют считать вещи из вторсырья «грязными» и вредными для здоровья">
            <p class="myth-text">Изделия из вторичного сырья — некачественные</p>
        </div>
        <div class="myth-card" data-myth="Раздельный сбор отходов не имеет смысла" data-reality="Исследования показали, что около 85% всех отходов могут быть переработаны, но на самом деле перерабатывается только 10–15%">
            <p class="myth-text">Раздельный сбор отходов не имеет смысла</p>
        </div>
        <div class="myth-card" data-myth="Переработка мусора в России неэффективна, и все вторсырье отправляется на свалки" data-reality="В России около 2,5 тыс. перерабатывающих предприятий, работающих не на полную мощность из-за нехватки сырья. В 2024 году планируется достичь 36% переработки и 60% сортировки мусора.">
            <p class="myth-text">Переработка мусора в России неэффективна, и все вторсырье отправляется на свалки</p>
        </div>
    </div>
</section>
<style>
    .myth-card {
        background-color: #fff;
        transition: background-color 0.3s ease;
    }
    .myth-card.reality {
        background-color: #9BE69D;
    }
    .myth-text {
        transition: color 0.3s ease;
    }
    .myth-card.reality .myth-text {
        color:rgb(0, 0, 0);
    }
</style>
    <footer>
        <div class="footer-logo">EcoBin</div>
    </footer>
</body>
<script>
    document.querySelectorAll('.myth-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.querySelector('.myth-text').textContent = card.dataset.reality;
            card.classList.add('reality');
        });
        card.addEventListener('mouseleave', () => {
            card.querySelector('.myth-text').textContent = card.dataset.myth;
            card.classList.remove('reality');
        });
    });
</script>
</html>