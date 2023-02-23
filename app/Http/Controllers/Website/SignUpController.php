<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\CustomerActivation;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use React\EventLoop\Loop;

use function React\Async\async;

class SignUpController extends Controller
{
    public function index(): View
    {
        return view('signup');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:8'
        ]);

        $customer = Customer::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => bcrypt($request->password),
            "is_active" => Customer::DEACTIVE
        ]);

        Loop::addTimer(1, async(function () use ($customer){
            Mail::to($customer->email)->send(new CustomerActivation($customer));
        }));

        return redirect()->route('customer.login')
            ->with('message', ['type' => 'success', 'message' => 'Activation email was send please check your email']);
    }

    public function active(Customer $customer): RedirectResponse
    {
        if ($customer->email_varified_at != null) { 
            return redirect()->route('customer.login');
        }

        $customer->update([
            'is_active' => Customer::ACTIVE,
            'email_varified_at' => now()
        ]);

        return redirect()->route('customer.login')
            ->with('message', ['type' => 'success', 'message' => 'Your account has been active please login']);
    }
}
