<?php

namespace App\Http\Controllers;

use App\Models\FastboatTrackAgent;
use App\Models\FastboatTrackGroupAgent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;

class FastboatTrackAgentController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FastboatTrackGroupAgent::query()->with('trackGroup.fastboat', 'customer');

        if ($request->has('q')) {
            $query->whereHas('customer', function ($query) use ($request) {
                $query->where('name', 'like', "%$request->q%");
            });
        }

        return inertia('FastboatTrackAgents/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function create()
    {
        return inertia('FastboatTrackAgents/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'fastboat_track_group_id' => 'required|exists:fastboat_track_groups,id',
            'tracks' => 'required|array',
            'tracks.*.id' => 'required|exists:fastboat_tracks,id',
            'tracks.*.price' => 'required|numeric',
        ]);

        DB::beginTransaction();
        $group = FastboatTrackGroupAgent::create([
            'customer_id' => $request->customer_id,
            'fastboat_track_group_id' => $request->fastboat_track_group_id,
        ]);

        foreach ($request->tracks as $track) {
            $group->tracksAgent()->create([
                'customer_id' => $request->customer_id,
                'fastboat_track_id' => $track['id'],
                'price' => $track['price'],
            ]);
        }
        DB::commit();

        return redirect()->route('price-agent.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function edit(FastboatTrackGroupAgent $group)
    {
        return inertia('FastboatTrackAgents/Form', [
            'group' => $group->load(['trackGroup.fastboat', 'tracks.track.source', 'tracks.track.destination', 'customer']),
        ]);
    }

    public function update(Request $request, FastboatTrackGroupAgent $group): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'fastboat_track_group_id' => 'required|exists:fastboat_track_groups,id',
            'tracks' => 'required|array',
            'tracks.*.id' => 'required|exists:fastboat_track_agents,id',
            'tracks.*.price' => 'required|numeric',
        ]);

        foreach ($request->tracks as $track) {
            FastboatTrackAgent::where('id', $track['id'])->update(['price' => $track['price']]);
        }

        return redirect()->route('price-agent.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FastboatTrackGroupAgent $group): void
    {
        $group->tracksAgent()->delete();
        $group->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
