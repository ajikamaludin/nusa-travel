<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\CustomerForgotPassword;
use App\Mail\CustomerResetPassword;
use App\Models\Customer;
use App\Services\AsyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('forgot/forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $customer = Customer::where('email', $request->email)->first();
        if ($customer != null) {
            $customer->update(['reset_token' => Str::random(254)]);
            AsyncService::async(function () use ($customer) {
                Mail::to($customer->email)->send(new CustomerForgotPassword($customer));
            });
        }

        return redirect()->route('customer.forgot-password.index')
            ->with('message', ['type' => 'success', 'message' => 'Email has been send, please follow any intruction in the mail.']);
    }

    public function show(Customer $customer)
    {
        return view('forgot/reset-password', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $customer->update([
            'password' => bcrypt($request->password),
            'reset_token' => Str::random(254),
        ]);
        AsyncService::async(function () use ($customer) {
            Mail::to($customer->email)->send(new CustomerResetPassword($customer));
        });

        return redirect()->route('customer.login')
            ->with('message', ['type' => 'success', 'message' => 'Password reset success, please login with new password.']);
    }
}
