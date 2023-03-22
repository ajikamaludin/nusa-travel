<?php

namespace App\Http\Controllers;

use App\Models\FastboatPlace;
use App\Models\FastboatTrackGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;

class FastboatTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = FastboatTrackGroup::query()->whereNull('data_source')->with(['fastboat', 'tracks', 'places.place']);

        if ($request->has('q')) {
            $query->whereHas('fastboat', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%")->orWhere('number', 'like', "%{$request->q}%");
            });
        }

        return inertia('FastboatTrack/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(20, '*', 'page'),
        ]);
    }

    /**
     * Show form
     */
    public function create(Request $request)
    {
        $place = FastboatPlace::query()->whereNull('data_source')->orderBy('name', 'asc');

        if ($request->place_q != '') {
            $place->where('name', 'like', "%{$request->place_q}%");
        }

        return inertia('FastboatTrack/Form', [
            'places' => $place->paginate(20, '*', 'place_page'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fastboat_id' => 'required|exists:fastboats,id',
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
        $group = FastboatTrackGroup::create([
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
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Show form
     */
    public function edit(Request $request, FastboatTrackGroup $group)
    {
        $place = FastboatPlace::query()->whereNull('data_source')->orderBy('name', 'asc');

        if ($request->place_q != '') {
            $place->where('name', 'like', "%{$request->place_q}%");
        }

        return inertia('FastboatTrack/Form', [
            'group' => $group->load(['places.place', 'tracks.source', 'tracks.destination']),
            'places' => $place->paginate(20, '*', 'place_page'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FastboatTrackGroup $group): RedirectResponse
    {
        $request->validate([
            'fastboat_id' => 'required|exists:fastboats,id',
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

        $match = false;
        if(count($places) == $group->places()->count()) {
            $matchs = [];
            $gplaces = $group->places()->orderBy('order', 'asc')->get();
            foreach($gplaces as $index => $gp) {
                $matchs[] = $places[$index]['place']->id == $gp->fastboat_place_id;
            }

            $match = !in_array(false, $matchs);
        }

        if ($match) {
            $tracks = collect($request->tracks);
            $group->tracks()->each(function ($gtrack) use ($tracks) {
                $track = $tracks->where('fastboat_source_id', '=', $gtrack->fastboat_source_id)
                ->where('fastboat_destination_id','=', $gtrack->fastboat_destination_id)->first();

                $gtrack->update([
                    'fastboat_source_id' => $track['fastboat_source_id'],
                    'fastboat_destination_id' => $track['fastboat_destination_id'],
                    'price' => $track['price'],
                    'arrival_time' => $track['arrival_time'],
                    'departure_time' => $track['departure_time'],
                    'is_publish' => $track['is_publish'],
                ]);
            });
            DB::commit();

            return redirect()->route('fastboat.track.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
        }

        $group->tracks()->each(function ($track) {
            $track->trackAgent()->each(function ($agent) {
                $agent->group()->delete();
            });
            $track->trackAgent()->delete();
        });

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
        DB::beginTransaction();
        $group->tracks()->each(function ($track) {
            $track->trackAgent()->each(function ($agent) {
                $agent->group()->delete();
            });
            $track->trackAgent()->delete();
        });

        $group->places()->delete();
        $group->tracks()->delete();
        $group->delete();
        DB::commit();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
