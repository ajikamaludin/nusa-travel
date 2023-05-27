<?php

namespace App\Http\Controllers;

use App\Models\FastboatTrack;
use App\Services\EkajayaService;
use Illuminate\Http\Request;

class EkajayaController extends Controller
{
    public function index(Request $request)
    {
        // listing track yang datasourcenya ekajaya dan sudah
        $query = FastboatTrack::with(['source', 'destination'])->where([
            ['data_source', '=', EkajayaService::class],
            ['attribute_json', '!=', null],
        ])->orderBy('updated_at', 'desc');

        if ($request->q != '') {
            $query
                ->whereHas('source', function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->q%");
                })
                ->whereHas('destination', function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->q%");
                })
                ->whereHas('fastboat', function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->q%");
                });
        }

        return inertia('Ekajaya/Index', [
            'query' => $query->paginate(),
        ]);
    }

    public function create()
    {
        return inertia('Ekajaya/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fastboat_track_id' => 'required|exists:fastboat_tracks,id',
            'price' => 'required|numeric',
        ]);

        $track = FastboatTrack::find($request->fastboat_track_id);

        $track->update([
            'price' => $request->price,
            'attribute_json' => json_encode([
                'use_custom_price' => $request->price,
            ]),
        ]);

        return redirect()->route('fastboat.ekajaya.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function edit(FastboatTrack $track)
    {
        return inertia('Ekajaya/Form', [
            'track' => $track,
        ]);
    }

    public function update(Request $request, FastboatTrack $track)
    {
        $request->validate([
            'fastboat_track_id' => 'required|exists:fastboat_tracks,id',
            'price' => 'required|numeric',
        ]);

        $track->update([
            'price' => $request->price,
            'attribute_json' => json_encode([
                'use_custom_price' => $request->price,
            ]),
        ]);

        return redirect()->route('fastboat.ekajaya.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(FastboatTrack $track)
    {
        $track->update(['attribute_json' => null]);

        return redirect()->route('fastboat.ekajaya.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
