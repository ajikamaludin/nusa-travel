<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FastboatTrackGroup;
use App\Models\FastboatTrackGroupAgent;
use Illuminate\Http\Request;

class FastboatTrackController extends Controller
{
    public function index(Request $request)
    {
        $query = FastboatTrackGroup::query()
            ->whereNull('data_source')
            ->with([
                'fastboat',
                'places.place',
                'tracks.source',
                'tracks.destination',
                'tracks',
            ]);

        if ($request->customer_id != '') {
            $trackGrupsAgentIds = FastboatTrackGroupAgent::where('customer_id', $request->customer_id)->get()->pluck('fastboat_track_group_id');
            $query->whereNotIn('id', $trackGrupsAgentIds);
        }

        if ($request->has('q')) {
            $query->whereHas('fastboat', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%")->orWhere('number', 'like', "%{$request->q}%");
            });
        }

        return $query->get();
    }
}
