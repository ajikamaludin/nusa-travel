<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Visitor;
use App\Services\GeneralService;

class BlogController extends Controller
{
    public function index()
    {
        $locale = GeneralService::getLocale();
        $posts = Post::with(['tags'])
            ->withCount(['visitors'])
            ->where('lang', $locale)
            ->where('is_publish', Post::PUBLISH)
            ->orderBy('created_at', 'desc');

        return view('blog', [
            'posts' => $posts->paginate(12),
        ]);
    }

    public function show(string $locale, Post $post)
    {
        Visitor::track([Post::class, $post->id]);
        $post = $post->loadCount(['visitors']);

        return view('blog-post', [
            'post' => $post->getTranslate(),
        ]);
    }
}
