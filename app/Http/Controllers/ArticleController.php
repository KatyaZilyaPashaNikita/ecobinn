<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Главная страница с последними статьями
     */
    public function homeArticles()
    {
        // Получаем последние 4 статьи с медиа-контентом и пагинацией
        $articles = Article::with('media')->latest()->paginate(4);
        
        // Проверяем, авторизован ли пользователь
        $isLoggedIn = auth()->check();
        
        // Возвращаем представление с данными
        return view('articles.show', [
            'articles' => $articles,
            'isLoggedIn' => $isLoggedIn, // Передаем информацию о статусе входа
            'page' => 'home'  // Мета-информация для различия представлений (например, для навигации)
        ]);
    }

    /**
     * Список всех статей
     */
    public function index(Request $request)
    {
        // Получаем параметр 'search' из запроса (если он существует)
        $search = $request->get('search');
    
        // Устанавливаем количество статей на странице (по умолчанию 100)
        $perPage = $request->get('perPage', 100);
    
        // Строим запрос для получения статей
        $query = Article::with('media')->latest();
    
        // Если задано слово для поиска, добавляем фильтрацию по названию
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
    
        // Получаем статьи с пагинацией
        $articles = $query->paginate($perPage);
    
        // Возвращаем представление с данными
        return view('articles.index', [
            'articles' => $articles, // Список статей с пагинацией
            'page' => 'index',  // Мета-информация для различия представлений
        ]);
    }
    

    /**
     * Форма создания новой статьи
     */
    public function create()
    {
        // Возвращаем представление для создания статьи
        return view('articles.create', [
            'page' => 'create'  // Мета-информация для различия представлений
        ]);
    }

    /**
     * Сохранение новой статьи
     */
    public function store(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|string',
            'poster' => 'required|image',
        ]);

        // Создание новой статьи в базе данных
        $article = Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        // Добавляем изображение в коллекцию
        $article->addMediaFromRequest('poster')->toMediaCollection('posters');

        // Перенаправляем на главную страницу
        return redirect()->route('articles.index');
    }

    /**
     * Показ полной статьи
     */
    public function show(Article $article)
    {
        // Возвращаем представление с данными
        return view('articles.show', [
            'article' => $article,
            'page' => 'show'  // Мета-информация для различия представлений
        ]);
    }

    /**
     * Показ формы редактирования статьи
     */
    public function edit(Article $article)
    {
        // Возвращаем представление с данными для редактирования
        return view('articles.show', [
            'article' => $article,
            'page' => 'edit'  // Мета-информация для различия представлений
        ]);
    }

    /**
     * Обновление статьи
     */
    public function update(Request $request, Article $article)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'poster' => 'nullable|image',
        ]);

        // Обновление данных статьи
        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        // Если загружено новое изображение, заменяем его
        if ($request->hasFile('poster')) {
            $article->clearMediaCollection('posters');  // Очищаем старую коллекцию
            $article->addMediaFromRequest('poster')->toMediaCollection('posters'); // Добавляем новое изображение
        }

        // Перенаправляем на страницу статьи
        return redirect()->route('posts.show', $article);
    }

    /**
     * Удаление статьи
     */
    public function destroy(Article $article)
    {
        // Удаление статьи из базы
        $article->delete();

        // Перенаправляем на главную страницу
        return redirect()->route('home');
    }
    

 
    
}
