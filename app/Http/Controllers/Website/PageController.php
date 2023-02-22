<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Page $page)
    {
        return view('page', ['page' => $page]);
    }

    public function faq(Request $request)
    {
        $query = Faq::query();

        if($request->has('q')){
            $query->where('question', 'like', "%$request->q%")
                    ->orWhere('answer', 'like', "%$request->q%");
        }

        return view('faq', [
            'faqs' => $query->orderBy('order', 'asc')->get(),
            'q' => $request->q
        ]);
    }
}
