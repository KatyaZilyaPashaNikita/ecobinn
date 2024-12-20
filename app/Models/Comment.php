<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', // Поле для текста комментария
        'user_id', // ID пользователя
        'post_id', // ID поста, если есть связь с постами
    ];

    /**
     * Связь с таблицей лайков комментариев
     */
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }
     /**
     * Определение связи: комментарий принадлежит пользователю.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   // Метод для подсчета лайков
   public function likeCount()
   {
       return $this->hasMany(CommentLike::class)->where('is_like', true)->count();
   }

   // Метод для подсчета дизлайков
   public function dislikeCount()
   {
       return $this->hasMany(CommentLike::class)->where('is_like', false)->count();
   }
}
