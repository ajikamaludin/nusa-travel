<?php

namespace App\Http\Controllers;

use App\Models\FastboatTrack;
use App\Services\GlobaltixService;
use Illuminate\Http\Request;

class GlobaltixController extends Controller
{
    public function index(Request $request)
    {
        $query = FastboatTrack::with(['source', 'destination'])
            ->where('data_source', GlobaltixService::class);

        return inertia('Globaltix/Index', [
            'query' => $query->paginate(),
        ]);
    }

    public function create()
    {
        return inertia('Globaltix/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_json' => 'required',
            'fastboat_source_id' => 'required|exists:fastboat_places,id',
            'fastboat_destination_id' => 'required|exists:fastboat_places,id',
            'price' => 'required|numeric',
            'arrival_time' => 'required',
            'departure_time' => 'required',
            'is_publish' => 'required|in:0,1',
        ]);

        FastboatTrack::create([
            'fastboat_source_id' => $request->fastboat_source_id,
            'fastboat_destination_id' => $request->fastboat_destination_id,
            'price' => $request->price,
            'arrival_time' => $request->arrival_time,
            'departure_time' => $request->departure_time,
            'is_publish' => $request->is_publish,
            'data_source' => GlobaltixService::class,
            'attribute_json' => json_encode($request->attribute_json),
        ]);

        return redirect()->route('fastboat.globaltix.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function edit(FastboatTrack $track)
    {
        return inertia('Globaltix/Form', [
            'track' => $track->load(['source', 'destination']),
        ]);
    }

    public function update(Request $request, FastboatTrack $track)
    {
        $request->validate([
            'attribute_json' => 'required',
            'fastboat_source_id' => 'required|exists:fastboat_places,id',
            'fastboat_destination_id' => 'required|exists:fastboat_places,id',
            'price' => 'required|numeric',
            'arrival_time' => 'required',
            'departure_time' => 'required',
            'is_publish' => 'required|in:0,1',
        ]);

        $track->update([
            'fastboat_source_id' => $request->fastboat_source_id,
            'fastboat_destination_id' => $request->fastboat_destination_id,
            'price' => $request->price,
            'arrival_time' => $request->arrival_time,
            'departure_time' => $request->departure_time,
            'is_publish' => $request->is_publish,
            'data_source' => GlobaltixService::class,
            'attribute_json' => json_encode($request->attribute_json),
        ]);

        return redirect()->route('fastboat.globaltix.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(FastboatTrack $track)
    {
        $track->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);

    }
}
