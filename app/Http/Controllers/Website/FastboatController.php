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
        $trackOne = null;

        if($request->ways == 1) {
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

        $rdate = Carbon::parse($date)->addDays(2);
        if ($request->return_date != '') {
            $rdate = Carbon::createFromFormat('Y-m-d',$request->return_date);
        }

        return view('fastboat', [
            'ways' => $request->ways ?? 1,
            'from' => $request->from,
            'to' => $request->to,
            'date' => $date->format('Y-m-d'),
            'rdate' => $rdate->format('Y-m-d'),
            'tracks_one' => $trackOne?->paginate(5),
            'tracks_two' => $trackBack?->get(),
        ]);
    }

    public function add(Request $request)
    {
        $login = true;
        if($login) {
            // buatkan order 
            // simpan item order
        } else {
            // simpan item di session
        }
    }

    public function mine()
    {}
}
