<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    use InteractsWithMedia;

    // Массив доступных для массового заполнения атрибутов
    protected $fillable = ['title', 'content', 'user_id', 'is_hidden']; // Добавляем is_hidden

    // Отключаем автоматическое управление временными метками
    public $timestamps = true;

    /**
     * Взаимодействие с пользователем
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Взаимодействие с комментариями
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Регистрация коллекции медиа (например, изображения постера)
     */
    public function registerMediaCollections(): void
    {
        // Регистрация коллекции 'posters' для хранения изображений
        $this->addMediaCollection('posters')
            ->singleFile(); // Если мы ожидаем одно изображение
    }

    /**
     * Получение URL первого изображения из коллекции 'posters'
     * Возвращает дефолтный URL, если изображение не найдено
     */
    public function getPosterUrl(): ?string
    {
        // Проверяем, есть ли медиа в коллекции 'posters'
        if ($this->hasMedia('posters')) {
            return $this->getFirstMediaUrl('posters');
        }

        // Если медиа нет, возвращаем дефолтный URL
        return asset('images/default_image.jpg'); // Путь к изображению по умолчанию
    }

    /**
     * Метод для переключения видимости статьи
     * Возвращает состояние статьи после изменения
     */
    public function toggleVisibility(): bool
    {
        $this->is_hidden = !$this->is_hidden;
        $this->save();

        return $this->is_hidden;
    }

    /**
     * Скоуп для получения только видимых статей
     */
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }
}
