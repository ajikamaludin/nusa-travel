<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Faq::query();

        if($request->has('q')) {
            $query->where('question', 'like', "%{$request->q}%");
        }

        return inertia('Faq/Index', [
            'query' => $query->orderBy('order', 'asc')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Faq/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'nullable'
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'order' => Faq::count() + 1
        ]);

        return redirect()->route('faq.index')
            ->with('message', ['type' => 'success', 'message' => 'Faq has beed saved']); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return inertia('Faq/Form', ['faq' => $faq]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'nullable'
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return redirect()->route('faq.index')
            ->with('message', ['type' => 'success', 'message' => 'Faq has beed updated']); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Faq has beed deleted']); 
    }
}
