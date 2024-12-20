<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Illuminate\Http\Request;

// app/Http/Controllers/ArticleController.php
class ArticleController extends Controller
{

    public function search(Request $request)
    {
        // Получаем параметр 'search' из запроса
        $search = $request->get('search');

        if ($search) {
            // Выполняем поиск по названию
            $articles = Article::where('title', 'like', '%' . $search . '%')->get();
            return view('articles.index', compact('articles'));
        }

        // Если поиск не задан, выводим все статьи
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }


    // Метод для скрытия статьи
    public function hide($id)
    {
        $article = Article::findOrFail($id);

        // Проверяем, является ли пользователь администратором
        if (auth()->check() && auth()->user()->is_admin) {
            $article->update(['is_hidden' => true]);

            return redirect()->route('articles.index')->with('status', 'Статья скрыта');
        }

        return redirect()->route('articles.index')->with('error', 'У вас нет прав для выполнения этого действия');
    }

    // Метод для восстановления статьи
    public function restore($id)
    {
        $article = Article::findOrFail($id);

        // Проверяем, является ли пользователь администратором
        if (auth()->check() && auth()->user()->is_admin) {
            $article->update(['is_hidden' => false]);

            return redirect()->route('articles.index')->with('status', 'Статья восстановлена');
        }

        return redirect()->route('articles.index')->with('error', 'У вас нет прав для выполнения этого действия');
    }

    // Оставшиеся методы
    public function homeArticles()
    {
        $articles = Article::with('media')->latest()->paginate(10);
        return view('home', compact('articles'));
    }

    public function index(Request $request)
    {
        $articles = Article::where(["is_hidden" => false]);

        // Фильтрация по заголовку
        if ($request->has('title')) {
            $articles->where('title', 'like', '%' . $request->input('title') . '%');
        }

        $articles = $articles->latest()->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // проверка для 'poster'
        ]);
    
        $article = new Article();
        $article->user_id = Auth::id();
        $article->title = $validated['title'];
        $article->content = $validated['content'];
        $article->is_hidden = false;  // Статья по умолчанию не скрыта
        $article->save();
    
        // Обработка изображения, если оно присутствует
        if ($request->hasFile('poster')) {
            // Сохраняем изображение в папку 'public/articles'
            $path = $request->file('poster')->store('public/articles');
            
            // Добавляем изображение в коллекцию 'images'
            $article->addMedia(storage_path("app/{$path}"))
                    ->toMediaCollection('images');
        }
    
        return redirect()->route('articles.index')->with('status', 'Статья успешно создана');
    }
    
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $validated['title'];
        $article->content = $validated['content'];
        $article->save();

        // Обработка нового изображения
        if ($request->hasFile('image')) {
            // Удаление старого изображения
            if ($article->media->isNotEmpty()) {
                $article->media->first()->delete();
            }

            // Сохранение нового изображения
            $path = $request->file('image')->store('public/articles');
            $article->addMedia(storage_path("app/{$path}"))
                    ->toMediaCollection('images');
        }

        return redirect()->route('articles.index')->with('status', 'Статья обновлена');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        // Удаление связанного медиа
        if ($article->media->isNotEmpty()) {
            $article->media->first()->delete();
        }

        return redirect()->route('articles.index')->with('status', 'Статья удалена');
    }
}
