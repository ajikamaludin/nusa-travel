<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard)
    {
        if ($guard == 'customer' && Auth::guard($guard)->check()) {
            return redirect()->route('customer.profile');
        }
        if ($guard == 'web' && Auth::guard($guard)->check()) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
