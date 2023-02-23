<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('customer.profile', [
            'customer' => Customer::find($request->user()->id)
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:customers,email,'.$request->user()->id,
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'nation' => 'nullable|string',
            'national_id' => 'nullable|string',
        ]);

        $customer = Customer::find($request->user()->id);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nation' => $request->nation,
            'national_id' => $request->national_id,
        ]);

        return redirect()->route('customer.profile')
            ->with('message', ['type' => 'success', 'message' => 'Profile update success']);
    }

    public function password(Request $request)
    {
        $request->validate(['password' => 'required|string|max:255|min:8|confirmed']);

        Customer::find($request->user()->id)->update(['password' => bcrypt($request->password)]);

        return redirect()->route('customer.profile')
            ->with('message', ['type' => 'success', 'message' => 'Password update success']);
    }

    public function destroy()
    {
        Auth::guard('customer')->logout();

        return redirect()->route('customer.login');
    }
}
