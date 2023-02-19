<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = Customer::query();

        if($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return inertia('Customer/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): void
    {
        $customer->delete();
    }
}
