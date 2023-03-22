<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FastboatPlace;
use Illuminate\Http\Request;

class FastboatPlaceController extends Controller
{
    public function index(Request $request)
    {
        $query = FastboatPlace::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return $query->select(['name', 'id'])->get();
    }
}
