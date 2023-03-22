<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fastboat;
use Illuminate\Http\Request;

class FastboatController extends Controller
{
    public function index(Request $request)
    {
        $query = Fastboat::query()->whereNull('data_source');

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return $query->get();
    }
}
