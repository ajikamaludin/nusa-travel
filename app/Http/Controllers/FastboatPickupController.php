<?php

namespace App\Http\Controllers;

use App\Models\FastboatPickup;
use Illuminate\Http\Request;
use Inertia\Response;

class FastboatPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = FastboatPickup::query()->with(['source', 'car']);

        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return inertia('FastboatPickup/Index', [
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
            'source_id' => 'required|exists:fastboat_places,id',
            'car_rental_id' => 'required|exists:car_rentals,id',
        ]);

        FastboatPickup::create([
            'name' => $request->name,
            'source_id' => $request->source_id,
            'car_rental_id' => $request->car_rental_id,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FastboatPickup $pickup): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'source_id' => 'required|exists:fastboat_places,id',
            'car_rental_id' => 'required|exists:car_rentals,id',
        ]);

        $pickup->update([
            'name' => $request->name,
            'source_id' => $request->source_id,
            'car_rental_id' => $request->car_rental_id,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FastboatPickup $pickup): void
    {
        $pickup->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
