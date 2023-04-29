<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query()
            ->where('is_active', Customer::ACTIVE);

        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        if ($request->has('agent')) {
            $query->where('is_agent', Customer::AGENT);
        }

        return $query->get();
    }
}
