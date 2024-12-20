<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Mews\Purifier\Facades\Purifier;

class Article extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = Purifier::clean($value);
    } 

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getPosterUrl()
    {
        return $this->getFirstMediaUrl('posters');
    }
}