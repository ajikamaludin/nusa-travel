<?php

namespace App\Http\Controllers;

use App\Models\FastboatTrackAgent;
use App\Services\GlobaltixService;
use Illuminate\Http\Request;

class GlobaltixAgentController extends Controller
{
    public function index(Request $request)
    {
        $query = FastboatTrackAgent::with(['customer', 'track'])
            ->where('data_source', GlobaltixService::class)
            ->orderBy('updated_at', 'desc');

        if ($request->agent != '') {
            $query->where('customer_id', $request->agent);
        }

        if ($request->q != '') {
            $query->whereHas('track', function ($q) use ($request) {
                return $q->where('attribute_json', 'like', "%$request->q%");
            });
        }

        return inertia('GlobaltixTrackAgent/Index', [
            'query' => $query->orderBy('updated_at', 'desc')->paginate(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fastboat_track_id' => 'required|exists:fastboat_tracks,id',
            'customer_id' => 'required|exists:customers,id',
            'price' => 'required|numeric',
        ]);

        FastboatTrackAgent::create([
            'fastboat_track_id' => $request->fastboat_track_id,
            'customer_id' => $request->customer_id,
            'price' => $request->price,
            'data_source' => GlobaltixService::class,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function update(Request $request, FastboatTrackAgent $trackAgent)
    {
        $request->validate([
            'fastboat_track_id' => 'required|exists:fastboat_tracks,id',
            'customer_id' => 'required|exists:customers,id',
            'price' => 'required|numeric',
        ]);

        $trackAgent->update([
            'fastboat_track_id' => $request->fastboat_track_id,
            'customer_id' => $request->customer_id,
            'price' => $request->price,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(FastboatTrackAgent $trackAgent)
    {
        $trackAgent->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
