<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\CarRental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CarRentalController extends Controller
{
    public function index(Request $request) 
    {
        $query = CarRental::query();

        if($request->person != '') {
            $query->where('capacity', '>=', $request->person);
        }

        $date = now();
        if ($request->date != '') {
            $date = Carbon::createFromFormat('Y-m-d',$request->date);
        }

        return view('car', [
            'cars' => $query->paginate(),
            'person' => $request->person,
            'date' => $date->format('Y-m-d'),
        ]);
    }
}
