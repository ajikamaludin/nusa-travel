<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog', [
            'posts' => Post::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function show(Post $post)
    {
        return view('blog-post', ['post' => $post]);
    }
}
