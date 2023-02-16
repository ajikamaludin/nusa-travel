<?php

namespace App\Http\Controllers;

use App\Models\FastboatTrack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class FastboatTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = FastboatTrack::query()->with(['source', 'destination']);

        if($request->has('q')) {
            $query->with([
                'source' => function($query) use($request) {
                    $query->where('name', 'like', "%{$request->q}%");
                }, 
                'destination' => function($query) use($request) {
                    $query->where('name', 'like', "%{$request->q}%");
                }
            ]);
        }
    
        return inertia('FastboatTrack/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        $request->validate([
            "fastboat_source_id" => 'required|exists:places,id',
            "fastboat_destination_id" => 'required|exists:places,id',
            "price" => 'required|numeric',
            "capacity" => 'required|numeric',
            "arrival_time" => 'required',
            "departure_time" => 'required',
        ]);

        FastboatTrack::create([
            "fastboat_source_id" => $request->fastboat_source_id,
            "fastboat_destination_id" => $request->fastboat_destination_id,
            "price" => $request->price,
            "capacity" => $request->capacity,
            "arrival_time" => $request->arrival_time,
            "departure_time" => $request->departure_time,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FastboatTrack $track): void
    {
        $request->validate([
            "fastboat_source_id" => 'required|exists:places,id',
            "fastboat_destination_id" => 'required|exists:places,id',
            "price" => 'required|numeric',
            "capacity" => 'required|numeric',
            "arrival_time" => 'required',
            "departure_time" => 'required',
        ]);

        $track->update([
            "fastboat_source_id" => $request->fastboat_source_id,
            "fastboat_destination_id" => $request->fastboat_destination_id,
            "price" => $request->price,
            "capacity" => $request->capacity,
            "arrival_time" => $request->arrival_time,
            "departure_time" => $request->departure_time,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FastboatTrack $track): void
    {
        $track->delete();
    }
}
