<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = TourPackage::query();

        if($request->has('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        return inertia('Blog/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }
}
