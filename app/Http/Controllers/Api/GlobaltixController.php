<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GlobaltixService;
use Illuminate\Http\Request;

class GlobaltixController extends Controller
{
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
