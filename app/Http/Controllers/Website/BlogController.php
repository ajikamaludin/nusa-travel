<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with(['tags'])->withCount(['visitors'])->where('is_publish', Post::PUBLISH)->orderBy('created_at', 'desc');

        return view('blog', [
            'posts' => $posts->paginate()
        ]);
    }

    public function show(Post $post)
    {
        Visitor::track([Post::class, $post->id]);

        return view('blog-post', ['post' => $post]);
    }
}
