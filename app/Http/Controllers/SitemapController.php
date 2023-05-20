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
        $lang = ['en', 'id', 'zh'];

        if ($request->page != '') {
            $posts = [];

            if ($request->page == 1) {
                $pages = Page::whereNull('lang')->orderBy('updated_at', 'desc')->get();
                $blogs = Post::whereNull('lang')->orderBy('updated_at', 'desc')->limit($limit)->get();

                foreach ($lang as $locale) {
                    foreach ($pages as $page) {
                        $posts[] = [
                            'url' => route('page.show', ['locale' => $locale, 'page' => $page]),
                            'updated_at' => $page->updated_at->toISOString(),
                        ];
                    }

                    $featurePages = [
                        [
                            'url' => route('fastboat', ['locale' => $locale]),
                            'updated_at' => Page::where('key', 'fastboat')->value('updated_at')->toISOString(),
                        ],
                        [
                            'url' => route('ekajaya-fastboat', ['locale' => $locale]),
                            'updated_at' => Page::where('key', 'fastboat-ekajaya')->value('updated_at')->toISOString(),
                        ],
                        [
                            'url' => route('tour-packages.index', ['locale' => $locale]),
                            'updated_at' => Page::where('key', 'tour-package')->value('updated_at')->toISOString(),
                        ],
                        [
                            'url' => route('car.index', ['locale' => $locale]),
                            'updated_at' => Page::where('key', 'car-rental')->value('updated_at')->toISOString(),
                        ],
                    ];

                    $posts = array_merge($posts, $featurePages);
                }

                foreach ($lang as $locale) {
                    foreach ($blogs as $post) {
                        $posts[] = [
                            'url' => route('blog.post', ['locale' => $locale, 'post' => $post]),
                            'updated_at' => $post->updated_at->toISOString(),
                        ];
                    }
                }
            } else {
                $posts = Post::whereNull('lang')->orderBy('updated_at', 'desc')
                    ->offset($request->page * $limit) //4
                    ->limit($limit) //1
                    ->get();

                foreach ($posts as $post) {
                    $posts[] = [
                        'url' => route('blog.post', ['locale' => 'en', 'post' => $post]),
                        'updated_at' => $post->updated_at->toISOString(),
                    ];
                }
            }

            return response()
                ->view('sitemap/page', [
                    'posts' => $posts,
                ], 200)
                ->header('Content-Type', 'application/atom+xml');
        }

        $page = Page::whereNull('lang')->count(); // 13
        $post = Post::whereNull('lang')->count(); // 4
        $data = ($post + $page) / $limit;
        $total = $data;
        $data = ceil($data) <= 0 ? 1 : ceil($data);

        return response()
            ->view('sitemap/index', [
                'pages' => range(1, $data),
                'total' => $total,
                'post' => $post,
                'page' => $page,
            ], 200)
            ->header('Content-Type', 'application/atom+xml');
    }
}
