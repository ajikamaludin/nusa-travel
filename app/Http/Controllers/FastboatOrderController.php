<?php

namespace App\Http\Controllers;

use App\Models\FastboatOrder;
use Illuminate\Http\Request;
use Inertia\Response;

class FastboatOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = FastboatOrder::query()->with(['track', 'customer']);

        if($request->has('q')) {
            $query->where('order_code', 'like', "%{$request->q}%");
        }

        return inertia('FastboatOrder/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }
}
