<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FastboatTrackGroup;
use Illuminate\Http\Request;

class FastboatTrackController extends Controller
{
    public function index(Request $request)
    {
        $query = FastboatTrackGroup::query()->with([
            'fastboat',
            'tracksAgent' => fn ($query) => $query->whereNull('customer_id')->orWhere('customer_id', '!=', $request->c),
            'places.place', 'tracksAgent.source','tracksAgent.source','tracksAgent.destination',
        ]);

        if ($request->has('q')) {
            $query->whereHas('fastboat', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%")->orWhere('number', 'like', "%{$request->q}%");
            });
        }

        return $query->get();
    }
}
