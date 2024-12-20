<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show()
    {
        return view('posts', [
            'post' => Article::all()
        ]);
    }
}
