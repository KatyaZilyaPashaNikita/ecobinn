<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        $isLoggedIn = Auth::check();
        $isAdmin = $isLoggedIn ? Auth::user()->is_admin : false;
        return view('home', compact('articles', 'isLoggedIn', 'isAdmin'));
    }
}