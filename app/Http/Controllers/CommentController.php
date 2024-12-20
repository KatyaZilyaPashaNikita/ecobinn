<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000'
        ]);

        $article->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id()
        ]);

        return back();
    }

    public function showComments(Article $article)
    {
        // Получаем все комментарии для конкретной статьи
        $comments = $article->comments()->with('user')->latest()->get();

        // Передаем переменную $comments и $article в представление
        return view('comments', compact('comments', 'article'));
    }
}

