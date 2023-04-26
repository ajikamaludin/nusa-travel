<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\CarRental;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CarRentalController extends Controller
{
    public function index(Request $request)
    {
        $query = CarRental::query()->where('is_publish', CarRental::READY);

        if ($request->person != '') {
            $query->where('capacity', '>=', $request->person);
        }

        $date = now();
        if ($request->date != '') {
            $date = Carbon::createFromFormat('Y-m-d', $request->date);
        }

        return view('car', [
            'cars' => $query->paginate(),
            'person' => $request->person,
            'date' => $date->format('Y-m-d'),
            'page' => Page::where('key', 'car-rental')->first(),
        ]);
    }
}
