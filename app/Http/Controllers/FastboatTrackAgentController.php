<?php

namespace App\Http\Controllers;

use App\Models\FastboatTrackAgent;
use App\Models\FastboatPlace;
use App\Models\FastboatTrackGroup;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;

class FastboatTrackAgentController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FastboatTrackGroup::query()->with(['fastboat', 'tracksAgents', 'places.place'])
        ->select('fastboat_track_groups.*','customers.name as customer_name','customer_id')
        ->join('fastboat_tracks','fastboat_tracks.fastboat_track_group_id','=','fastboat_track_groups.id')
        ->join('fastboat_track_agents','fastboat_track_agents.fastboat_track_id','=','fastboat_tracks.id')
        ->join('customers','customers.id','=','fastboat_track_agents.customer_id')
        ->groupBy('fastboat_track_group_id','customer_id')
        ;
        
        if ($request->has('q')) {
            $query->whereHas('tracksAgents.trackAgent.customer', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}");
            });  
        }
        // dd($query->toSql());
        return inertia('FastboatTrackAgents/Index', [
            'query' => $query->orderBy('fastboat_track_agents.created_at', 'desc')->paginate(20, '*', 'page'),
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

    public function edit(Request $request,FastboatTrackGroup $priceagent)
    {
      
        $place = FastboatPlace::query();
        if ($request->place_q != '') {
            $place->whereHas('tracksAgents', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%");
            });
        }
        // $query = FastboatTrackGroup::query()->with(['fastboat', 'tracksAgent'=> fn($query) => $query->where('fastboat_track_id','=',$priceagent->fastboat_track_id)->Where('customer_id','=',$priceagent->customer_id), 'places.place']);
      
        return inertia('FastboatTrackAgents/Form', [
            // 'group' =>$priceagent,
            'places' => $place->paginate(20, '*', 'place_page'),
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tracks' => 'required|array',
            'tracks.*.fastboat_source_id' => 'required|exists:fastboat_places,id',
            'tracks.*.fastboat_destination_id' => 'required|exists:fastboat_places,id',
            'tracks.*.price' => 'required|numeric',
            'tracks.*.arrival_time' => 'required',
            'tracks.*.departure_time' => 'required',
            'tracks.*.is_publish' => 'required|in:0,1',
        ]);
        foreach ($request->tracks as $track) {
            // dd($track);
            FastboatTrackAgent::create([
                'customer_id' => $request->customer_id,
                'fastboat_track_id' => $track['id'],
                'price' => $track['price']
            ]);
        }

        return redirect()->route('price-agent.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

   

    public function update(Request $request, FastboatTrackGroup $group): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'places' => 'required|array|min:2',
            'places.*.fastboat_place_id' => 'required|exists:fastboat_places,id',
            'places.*.order' => 'required|numeric',
            'tracks' => 'required|array',
            'tracks.*.fastboat_source_id' => 'required|exists:fastboat_places,id',
            'tracks.*.fastboat_destination_id' => 'required|exists:fastboat_places,id',
            'tracks.*.price' => 'required|numeric',
            'tracks.*.arrival_time' => 'required',
            'tracks.*.departure_time' => 'required',
            'tracks.*.is_publish' => 'required|in:0,1',
        ]);

        $placeIds = collect($request->places)->pluck('fastboat_place_id')->toArray();
        $places = FastboatPlace::whereIn('id', $placeIds)->get();
        $places = collect($request->places)->map(function ($item) use ($places) {
            $place = $places->where('id', $item['fastboat_place_id'])->first();
            $item['place'] = $place;

            return $item;
        })->sortBy('order', SORT_NATURAL);

        DB::beginTransaction();
        $group->places()->delete();
        $group->tracks()->delete();

        $group->update([
            'fastboat_id' => $request->fastboat_id,
            'name' => $places->first()['place']['name'].' - '.$places->last()['place']['name'],
        ]);

        $places->each(function ($place) use ($group) {
            $group->places()->create([
                'fastboat_place_id' => $place['fastboat_place_id'],
                'order' => $place['order'],
            ]);
        });

        foreach ($request->tracks as $track) {
            $group->tracks()->create([
                'fastboat_source_id' => $track['fastboat_source_id'],
                'fastboat_destination_id' => $track['fastboat_destination_id'],
                'price' => $track['price'],
                'arrival_time' => $track['arrival_time'],
                'departure_time' => $track['departure_time'],
                'is_publish' => $track['is_publish'],
            ]);
        }
        DB::commit();

        return redirect()->route('fastboat.track.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FastboatTrackGroup $group): void
    {
        $group->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
