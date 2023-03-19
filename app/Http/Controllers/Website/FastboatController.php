<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FastboatController extends Controller
{
    public function index(Request $request)
    {
        $date = now();
        if ($request->date != '') {
            $date = Carbon::createFromFormat('m/d/Y', $request->date);
        }

        $rdate = Carbon::parse($date)->addDays(2);
        if ($request->return_date != '') {
            $rdate = Carbon::createFromFormat('m/d/Y', $request->return_date);
        }

        $data = [
            'ways' => $request->ways ?? 1,
            'from' => $request->from,
            'to' => $request->to,
            'date' => $date->format('Y-m-d'),
            'rdate' => $rdate->format('Y-m-d'),
            'no_passengers' => $request->no_passengers ?? '1',
            'infants' => $request->infants ?? '0',
        ];

        return view('fastboat', $data);
    }
}
