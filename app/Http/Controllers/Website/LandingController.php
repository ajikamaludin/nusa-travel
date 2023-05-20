<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FastboatPlace;
use App\Models\File;
use App\Models\Page;
use App\Models\Post;
use App\Models\TourPackage;
use App\Models\Visitor;
use App\Services\GeneralService;

class LandingController extends Controller
{
    public function index()
    {
        Visitor::track([Visitor::class, 'LANDING_PAGE']);

        $locale = GeneralService::getLocale();
        $posts = Post::with(['tags'])->withCount(['visitors'])
            ->where('is_publish', Post::PUBLISH)
            ->where('lang', $locale)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $page = Page::where('key', 'home')->first()->getTranslate();

        return view('home', [
            'places' => FastboatPlace::whereNull('data_source')->select('name')->get()->pluck('name'),
            'posts' => $posts,
            'faqs' => Faq::orderBy('order', 'asc')->limit(4)->get(),
            'images' => File::where('show_on', '!=', 0)->orderBy('show_on', 'asc')->get(),
            'packages' => TourPackage::where('is_publish', TourPackage::PUBLISH)->orderBy('updated_at', 'desc')->limit(4)->get(),
            'page' => $page,
        ]);
    }

    public function acceptCookie()
    {
        $cookie = cookie('accept', 'agree', 1 * (24 * 60 * 365));

        return response('Ok')->cookie($cookie);
    }
}
