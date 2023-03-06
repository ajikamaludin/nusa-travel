<?php

namespace App\Http\Controllers;

use App\Models\Fastboat;
use Illuminate\Http\Request;

class FastboatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Fastboat::query();

        if($request->has('q')) {
            $query->where('question', 'like', "%{$request->q}%");
        }

        return inertia('Fastboat/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Fastboat/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable',
            'capacity' => 'required|numeric',
            'cover_image' => 'required|image',
        ]);

        $file = $request->file('cover_image');
        $file->store('uploads', 'public');

        Fastboat::create([
            'number' => $request->number,
            'name' => $request->name,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'cover_image' => $file->hashName('uploads')
        ]);

        return redirect()->route('fastboat.fastboat.index')
            ->with('message', ['type' => 'success', 'message' => 'Fastboat has beed saved']); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fastboat $fastboat)
    {
        return inertia('Fastboat/Form', ['fastboat' => $fastboat]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fastboat $fastboat)
    {
        $request->validate([
            'number' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable',
            'capacity' => 'required|numeric',
            'cover_image' => 'nullable|image',
        ]);

        if($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $file->store('uploads', 'public');
            $fastboat->cover_image = $file->hashName('uploads');
        }

        $fastboat->update([
            'number' => $request->number,
            'name' => $request->name,
            'description' => $request->description,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('fastboat.fastboat.index')
            ->with('message', ['type' => 'success', 'message' => 'Fastboat has beed updated']); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fastboat $fastboat)
    {
        $fastboat->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Fastboat has beed deleted']); 
    }
}
