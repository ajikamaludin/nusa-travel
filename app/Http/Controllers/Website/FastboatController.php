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
        $query = FastboatTrack::query()->with(['source', 'destination']);

        if($request->from != '') {
            $query->whereHas('source', function($query) use ($request) {
                $query->where('name', '=', $request->from);
            });
        }

        if($request->to != '') {
            $query->whereHas('destination', function($query) use ($request) {
                $query->where('name', '=', $request->to);
            });
        }

        $query2 = null;

        if ($request->ways == 2) {
            $query2 = FastboatTrack::query()->with(['source', 'destination']);

            if($request->from != '') {
                $query2->whereHas('source', function($query) use ($request) {
                    $query->where('name', '=', $request->to);
                });
            }

            if($request->to != '') {
                $query2->whereHas('destination', function($query) use ($request) {
                    $query->where('name', '=', $request->from);
                });
            }

            $query2 = $query2->paginate(20, '*', 'track_two');
        }

        $date = $return_date = now()->format('Y-m-d');
        if ($request->has('date')) {
            $date = Carbon::createFromFormat('Y-m-d',$request->date)->format('Y-m-d');
        }
        if ($request->return_date != '') {
            $return_date = Carbon::createFromFormat('Y-m-d',$request->return_date)->format('Y-m-d');
        }

        return view('fastboat', [
            'ways' => $request->ways ?? 1,
            'from' => $request->from,
            'to' => $request->to,
            'date' => $date,
            'return_date' => $return_date,
            'tracks_one' => $query->paginate(20),
            'tracks_two' => $query2,
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
