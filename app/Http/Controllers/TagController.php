<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = Tag::query();

        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return inertia('Tag/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Tag::create(['name' => $request->name]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag->update(['name' => $request->name]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): void
    {
        $tag->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
