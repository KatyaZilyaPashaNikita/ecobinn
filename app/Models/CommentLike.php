<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = ['comment_id', 'user_id', 'is_like'];

    /**
     * Связь с комментариями
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Связь с пользователями
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
