<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function edit(Page $page)
    {
        return inertia('Page/Form', [
            'page' => $page
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $page->update(['body' => $request->body]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']); 
    }
}
