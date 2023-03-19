<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index(Request $request) 
    {
        $limit = 20;
        if($request->page != '') {
            $posts = [];

            if($request->page == 1) {
                $pages = Page::orderBy('updated_at', 'desc')->get();
                foreach($pages as $page) {
                    $posts[] = [
                        'url' => route('page.show', $page),
                        'updated_at' => $page->updated_at->toISOString()
                    ];
                }

                if(count($posts) < $limit) {
                    $pages = Post::orderBy('updated_at', 'desc')->limit($limit - count($posts))->get();

                    foreach($pages as $post) {
                        $posts[] = [
                            'url' => route('blog.post', $post),
                            'updated_at' => $post->updated_at->toISOString()
                        ];
                    }
                }
            } else {
                $pages = Post::orderBy('updated_at', 'desc')
                            ->offset($request->page * $limit) //4
                            ->limit($limit) //1
                            ->get();

                foreach($pages as $post) {
                    $posts[] = [
                        'url' => route('blog.post', $post),
                        'updated_at' => $post->updated_at->toISOString()
                    ];
                }
            }
            

            return response()
            ->view('sitemap/page', [
                'posts' => $posts,
            ], 200)
            ->header('Content-Type', 'application/atom+xml');
        }
        
        $page = Page::count(); // 5
        $post = Post::count(); // 4
        $data = $post / $limit;
        $data = floor($data) <= 0 ? 1 : floor($data) ;

        return response()
            ->view('sitemap/index', [
                'pages' => range(1, $data),
            ], 200)
            ->header('Content-Type', 'application/atom+xml');
    }
}
