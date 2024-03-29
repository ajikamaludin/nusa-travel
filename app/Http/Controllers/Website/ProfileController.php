<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DepositHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('customer.profile', [
            'customer' => Customer::find($request->user()->id),
        ]);
    }

    public function apitoken(Request $request)
    {
        return view('customer.token', [
            'customer' => Customer::find($request->user()->id),
        ]);
    }

    public function regenerate(Request $request)
    {
        $customer = Customer::find($request->user()->id);
        $customer->update([
            'token' => Hash::make(Str::random(10)),
        ]);

        return redirect()->route('customer.apitoken')
            ->with('message', ['type' => 'success', 'message' => 'api token regenerate success']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:customers,email,' . $request->user()->id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:255|unique:customers,phone,' . $request->user()->id,
            'address' => 'nullable|string',
            'nation' => 'nullable|string',
            'national_id' => 'nullable|numeric',
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

    public function danger_area()
    {
        return view('customer/danger_area');
    }

    public function close_customer(Request $request)
    {
        $request->validate(['deleted_reason' => 'required|string']);

        $customer = Customer::find($request->user()->id);

        $customer->update([
            'name' => 'Deleted User',
            'is_active' => Customer::DEACTIVE,
            'deleted_reason' => $request->reason
        ]);

        Auth::guard('customer')->logout();

        return redirect()->route('customer.login')
            ->with('message', ['type' => 'success', 'message' => 'Your account is deleted']);
    }

    public function deposite(Request $request)
    {
        $query = DepositHistory::where('customer_id', $request->user()->id)
            ->orderBy('created_at', 'desc');

        return view('customer/deposite_transaction', [
            'histories' => $query->paginate(),
        ]);
    }
}
