<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Response;

class AgentController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Customer::query();

        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return inertia('Agent/Index', [
            'query' => $query->where('is_agent', '1')->orderBy('created_at', 'desc')->paginate(),
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
            'password' => 'nullable|string',
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nation' => $request->nation,
            'national_id' => $request->national_id,
            'password' => bcrypt($request->passwor),
            'is_active' => Customer::ACTIVE,
            'is_agent' => Customer::AGENT,
            'token' => Hash::make(Str::random(10)),
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Agent has beed saved']);
    }

    public function update(Request $request, Customer $agent)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:customers,email,'.$agent->id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:255',
            'address' => 'nullable|string',
            'nation' => 'nullable|string',
            'national_id' => 'nullable|numeric',
            'password' => 'nullable|string',
        ]);

        if ($request->input('password') != '') {
            $agent->update(['password' => bcrypt($request->password)]);
        }

        $agent->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nation' => $request->nation,
            'national_id' => $request->national_id,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Agent has beed updated']);
    }

    public function destroy(Customer $agent): void
    {
        $agent->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Agent has beed deleted']);
    }
}
