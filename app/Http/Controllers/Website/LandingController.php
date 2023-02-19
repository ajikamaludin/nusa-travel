<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\FastboatPlace;
use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request, $locale = null) 
    {
        if ($locale != null) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }

        Visitor::track([Visitor::class, 'LANDING_PAGE']);

        return view('welcome', [
            'places' => FastboatPlace::select('name')->get()->pluck('name'),
            'posts' => Post::orderBy('created_at', 'desc')->limit(4)->get()
        ]);
    }
}
