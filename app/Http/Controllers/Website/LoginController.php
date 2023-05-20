<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\GeneralService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();
        if ($customer == null) {
            return redirect()->route('customer.login')
                ->with('message', ['type' => 'error', 'message' => 'Credential not valid']);
        }

        if ($customer->is_active == Customer::DEACTIVE) {
            return redirect()->route('customer.login')
                ->with('message', ['type' => 'error', 'message' => 'Account is not actived']);
        }

        $isAllowed = Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => Customer::ACTIVE], $request->remember);

        if (!$isAllowed) {
            return redirect()->route('customer.login')
                ->with('message', ['type' => 'error', 'message' => 'Credential not valid']);
        }

        session()->remove('carts');

        return redirect()->route('home.index', ['locale' => GeneralService::getLocale('en')]);
    }
}
