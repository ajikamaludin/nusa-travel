<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\File;
use App\Models\Page;
use App\Models\Visitor;
use App\Services\GeneralService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(string $locale, Page $page)
    {
        Visitor::track([Page::class, $page->id]);

        return view('page', [
            'page' => $page->getTranslate()
        ]);
    }

    public function faq(Request $request)
    {
        $query = Faq::query();

        if ($request->has('q')) {
            $query->where('question', 'like', "%$request->q%")
                ->orWhere('answer', 'like', "%$request->q%");
        }

        $page = Page::where('key', 'faq')->first()->getTranslate();
        return view('faq', [
            'faqs' => $query->orderBy('order', 'asc')->get(),
            'q' => $request->q,
            'page' => $page,
        ]);
    }

    public function gallery()
    {
        return view('gallery', [
            'images' => File::orderBy('updated_at', 'desc')->paginate(),
        ]);
    }
}
