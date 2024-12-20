<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PostController;
use App\Models\Article;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/search', [ArticleController::class, 'search'])->name('search');
Route::get('/', function () {
    return redirect('/home');
});

Route::resource('articles', ArticleController::class)->except(['show']);

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

Route::get('/map', [MapController::class, 'index'])->name('map');


// Маршруты для редактирования комментариев
Route::middleware(['auth'])->group(function () {
    // Маршрут для редактирования комментария
    Route::get('/articles/{article}/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::get('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::put('/articles/{article}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update')->middleware('auth');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');


Route::post('/articles/{article}/hide', [ArticleController::class, 'hide'])->name('articles.hide');
Route::post('/articles/{article}/restore', [ArticleController::class, 'restore'])->name('articles.restore');