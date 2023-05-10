<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FastboatTrack;
use App\Services\GlobaltixService;
use Illuminate\Http\Request;

class GlobaltixController extends Controller
{
    public function tracks(Request $request)
    {
        $query = FastboatTrack::where('data_source', GlobaltixService::class)
            ->orderBy('updated_at', 'desc');

        if ($request->q != '') {
            $query->where('attribute_json', 'like', "%$request->q%");
        }

        return $query->get();
    }

    public function products(Request $request)
    {
        $products = GlobaltixService::getProducts();

        return $products;
    }

    public function options(Request $request)
    {
        $options = GlobaltixService::getOptions($request->product_id);

        return $options;
    }
}
