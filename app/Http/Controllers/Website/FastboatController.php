<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\FastboatTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FastboatController extends Controller
{
    public function index(Request $request)
    {
        $trackOne = FastboatTrack::query()->with(['source', 'destination']);

        if($request->from != '') {
            $trackOne->whereHas('source', function($query) use ($request) {
                $query->where('name', '=', $request->from);
            });
        }

        if($request->to != '') {
            $trackOne->whereHas('destination', function($query) use ($request) {
                $query->where('name', '=', $request->to);
            });
        }

        $trackBack = null;

        if ($request->ways == 2) {
            $trackBack = FastboatTrack::query()->with(['source', 'destination']);

            if($request->from != '') {
                $trackBack->whereHas('source', function($query) use ($request) {
                    $query->where('name', '=', $request->to);
                });
            }

            if($request->to != '') {
                $trackBack->whereHas('destination', function($query) use ($request) {
                    $query->where('name', '=', $request->from);
                });
            }
        }

        $date = now();
        if ($request->date != '') {
            $date = Carbon::createFromFormat('Y-m-d',$request->date);
        }
        $trackOne->withCount(['item_ordered' => function ($query) use($date) {
            return $query->whereDate('date', $date);
        }] );

        $rdate = Carbon::parse($date)->addDays(2);
        if ($request->return_date != '') {
            $rdate = Carbon::createFromFormat('Y-m-d',$request->return_date);
        }
        $trackBack?->withCount(['item_ordered' => function ($query) use($rdate) {
            return $query->whereDate('date', $rdate);
        }] );

        $data = [
            'ways' => $request->ways ?? 1,
            'from' => $request->from,
            'to' => $request->to,
            'date' => $date->format('Y-m-d'),
            'rdate' => $rdate->format('Y-m-d'),
        ];
        return view('fastboat', [
            ...$data,
            'tracks_one' => $trackOne?->paginate(20, '*', 'page'),
            'tracks_two' => $trackBack?->paginate(20, '*', 're_page'),
        ]);
    }

    public function mine()
    {}
}
