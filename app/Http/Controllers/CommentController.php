<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Показать форму для редактирования комментария.
     *
     * @param  int  $articleId
     * @param  int  $commentId
     * @return \Illuminate\View\View
     */
    public function edit($articleId, $commentId)
    {
        // Находим статью по ID
        $article = Article::findOrFail($articleId);

        // Находим комментарий по ID
        $comment = Comment::where('article_id', $articleId)
                          ->where('id', $commentId)
                          ->firstOrFail();

        // Проверяем, что автор комментария совпадает с текущим пользователем
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого комментария.');
        }

        // Возвращаем представление с комментариями
        return view('articles.edit', compact('article', 'comment'));
    }

    /**
     * Обновить комментарий в базе данных.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $articleId
     * @param  int  $commentId
     * @return \Illuminate\Http\RedirectResponse
     */ public function store(Request $request, Article $article)
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
    public function update(Request $request, $articleId, $commentId)
    {
        // Валидация данных
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Находим статью по ID
        $article = Article::findOrFail($articleId);

        // Находим комментарий по ID
        $comment = Comment::where('article_id', $articleId)
                          ->where('id', $commentId)
                          ->firstOrFail();

        // Проверяем, что автор комментария совпадает с текущим пользователем
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого комментария.');
        }

        // Обновляем содержание комментария
        $comment->content = $validated['content'];
        $comment->save();

        // Перенаправляем на страницу статьи с сообщением об успешном обновлении
        return redirect()->route('articles.show', $articleId)
                         ->with('success', 'Комментарий успешно обновлен.');
    }
    public function destroy(Comment $comment)
    {
        // Проверка на права администратора
        if (auth()->user()->is_admin) {
            $comment->delete();  // Удаление комментария
            return redirect()->back()->with('status', 'Комментарий удалён.');
        }

        return redirect()->back()->with('error', 'У вас нет прав для удаления комментариев.');
    }
}
