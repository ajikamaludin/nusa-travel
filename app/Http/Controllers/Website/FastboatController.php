<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FastboatController extends Controller
{
    public function index(Request $request)
    {
        return $request->input();
    }
}
