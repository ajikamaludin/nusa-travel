<?php

namespace App\Http\Controllers;

use App\Models\FastboatDropoff;
use Illuminate\Http\Request;
use Inertia\Response;

class FastboatDropoffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = FastboatDropoff::query();

        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return inertia('FastboatDropoff/Index', [
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

        FastboatDropoff::create(['name' => $request->name]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FastboatDropoff $dropoff): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $dropoff->update(['name' => $request->name]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FastboatDropoff $dropoff): void
    {
        $dropoff->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
