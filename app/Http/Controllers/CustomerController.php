<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Response;

class CustomerController extends Controller
{
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:customers,email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:255',
            'address' => 'nullable|string',
            'nation' => 'nullable|string',
            'national_id' => 'nullable|numeric',
            'password' => 'nullable|string'
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nation' => $request->nation,
            'national_id' => $request->national_id,
            'password' => bcrypt($request->passwor),
            'is_active' => Customer::DEACTIVE
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Customer has beed saved']); 

    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:customers,email,'.$customer->id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:255',
            'address' => 'nullable|string',
            'nation' => 'nullable|string',
            'national_id' => 'nullable|numeric',
            'password' => 'nullable|string'
        ]);

        if($request->input('password') != '') {
            $customer->update(['password' => bcrypt($request->password)]);
        }

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nation' => $request->nation,
            'national_id' => $request->national_id,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Customer has beed updated']); 
    }

    public function destroy(Customer $customer): void
    {
        $customer->delete();
        
        session()->flash('message', ['type' => 'success', 'message' => 'Customer has beed deleted']); 
    }
}
