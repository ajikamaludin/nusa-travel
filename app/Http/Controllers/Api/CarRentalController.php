<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarRental;
use Illuminate\Http\Request;

class CarRentalController extends Controller
{
    public function index(Request $request)
    {
        $query = CarRental::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        if ($request->with_paginate != '') {
            return $query->paginate();
        }

        return $query->get();
    }
}
