<?php

namespace App\Http\Controllers;

use App\Models\FastboatPlace;
use Illuminate\Http\Request;
use Inertia\Response;

class FastboatPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = FastboatPlace::query();

        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return inertia('FastboatPlace/Index', [
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

        FastboatPlace::create(['name' => $request->name]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FastboatPlace $place): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $place->update(['name' => $request->name]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FastboatPlace $place): void
    {
        $place->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
