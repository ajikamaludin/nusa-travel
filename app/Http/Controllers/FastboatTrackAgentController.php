<?php

namespace App\Http\Controllers;

use App\Models\FastboatPlace;
use App\Models\FastboatTrackAgent;
use App\Models\FastboatTrackGroup;
use App\Models\FastboatTrackGroupAgent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;

class FastboatTrackAgentController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FastboatTrackGroupAgent::query()->with('trackGroup.fastboat', 'customer')
        ->join('fastboat_track_agents', 'fastboat_track_agents.fast_track_group_agents_id', '=', 'fast_track_group_agents.id')
        ->select('fast_track_group_agents.*', DB::raw('sum(fastboat_track_agents.price) as price'))
        ->groupBy('fast_track_group_agents.id');

        if ($request->has('q')) {
            $query->whereHas('customer', function ($query) use ($request) {
                $query->where('name', 'like', "%$request->q%");
            });
        }

        return inertia('FastboatTrackAgents/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(20, '*', 'page'),
        ]);
    }

    public function create(Request $request)
    {
        $place = FastboatTrackGroup::query();
        if ($request->place_q != '') {
            $place->where('name', 'like', "%{$request->place_q}%");
        }

        return inertia('FastboatTrackAgents/Form', [
            'places' => $place->paginate(20, '*', 'place_page'),
        ]);
    }

    public function edit(Request $request, FastboatTrackGroupAgent $priceagent)
    {

        $place = FastboatPlace::query();
        if ($request->place_q != '') {
            $place->whereHas('tracksAgents', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%");
            });
        }
        // dd($priceagent);
        $query = $priceagent->load(['customer', 'trackGroup', 'tracksAgent.tracks', 'trackGroup.places.place', 'tracksAgent.tracks.source', 'tracksAgent.tracks.destination']);
        // dd($priceagent);
        return inertia('FastboatTrackAgents/Form', [
            'group' => $query,
            'places' => $place->paginate(20, '*', 'place_page'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'fastboat_id' => 'required|exists:fastboat_track_groups,id',
            'tracks' => 'required|array',

        ]);
        // dd($request->fastboat_id);
        DB::beginTransaction();
        $group = FastboatTrackGroupAgent::create([
            'customer_id' => $request->customer_id,
            'fastboat_track_group_id' => $request->fastboat_id,

        ]);
        // dd($request->tracks);
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

    public function update(Request $request, FastboatTrackGroupAgent $group): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'fastboat_id' => 'required|exists:fastboat_track_groups,id',
        ]);
        // dd($request);
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
        // dd($group);
        $group->delete();
        $group->tracksAgent()->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
