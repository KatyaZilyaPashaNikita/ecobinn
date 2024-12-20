<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    /**
     * Переключение лайка или дизлайка.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleLike(Request $request, Comment $comment)
    {
        // Валидация входящих данных
        $validated = $request->validate([
            'is_like' => 'required|boolean',
        ]);

        // Проверка, есть ли уже лайк/дизлайк от текущего пользователя
        $existingLike = CommentLike::where('comment_id', $comment->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingLike) {
            // Если лайк/дизлайк существует, обновляем его
            $existingLike->update(['is_like' => $validated['is_like']]);
        } else {
            // Если не существует, создаем новый лайк/дизлайк
            CommentLike::create([
                'comment_id' => $comment->id,
                'user_id' => auth()->id(),
                'is_like' => $validated['is_like'],
            ]);
        }

        // Возвращаем обновленное количество лайков и дизлайков
        return response()->json([
            'like_count' => $comment->likeCount(),
            'dislike_count' => $comment->dislikeCount(),
        ]);
    }
}
