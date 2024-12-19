<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        // Получаем 3 последние статьи для отображения на главной странице
        $latestArticles = Article::latest()->take(3)->get();

        // Получаем оставшиеся статьи (все кроме последних 3)
        $articles = Article::latest()->paginate(10);

        // Проверяем, авторизован ли пользователь
        $isLoggedIn = Auth::check();

        // Проверяем, является ли пользователь администратором
        $isAdmin = $isLoggedIn ? Auth::user()->is_admin : false;

        // Передаем данные в представление
        return view('home', compact('latestArticles', 'articles', 'isLoggedIn', 'isAdmin'));
    }
}
