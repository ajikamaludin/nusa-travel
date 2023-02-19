<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('customer.profile');
    }

    public function destroy()
    {
        Auth::guard('customer')->logout();

        return redirect()->route('customer.login');
    }
}
