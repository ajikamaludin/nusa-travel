<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = TourPackage::where('is_publish', TourPackage::PUBLISH)->orderBy('updated_at', 'desc');

        return view('packages', [
            'packages' => $query->paginate(),
            'page' => Page::where('key', 'tour-package')->first(),
        ]);
    }

    public function show(TourPackage $package)
    {
        return view('package-detail', [
            'package' => $package->load(['images', 'prices']),
        ]);
    }
}
