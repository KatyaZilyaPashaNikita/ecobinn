<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PostController;

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
});

Route::put('/articles/{article}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update')->middleware('auth');
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');