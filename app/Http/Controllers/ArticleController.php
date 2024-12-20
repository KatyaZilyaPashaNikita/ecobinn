<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('ru');
    }

    public function homeArticles()
    {
        $articles = Article::with('media')
            ->latest()
            ->paginate(4);
        
        $isLoggedIn = auth()->check();
            
        return view('home', [
            'articles' => $articles
        ]);
    }

    public function index()
    {
        $articles = Article::with('media')->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|string', // Текст с тегами <p>
            'poster' => 'required|image',
        ]);

        $article = Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        $article->addMediaFromRequest('poster')->toMediaCollection('posters');

        return redirect()->route('home');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'poster' => 'nullable|image',
        ]);

        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        if ($request->hasFile('poster')) {
            $article->clearMediaCollection('posters');
            $article->addMediaFromRequest('poster')->toMediaCollection('posters');
        }

        return redirect()->route('articles.show', $article);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('home');
    }
}
