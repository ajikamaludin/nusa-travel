<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('authorization');
        $agent = Customer::where('token', '=', $token)->first();

        if ($agent != null) {
            Auth::guard('authtoken')->setUser($agent);

            return $next($request);
        } else {
            return response()->json(['message' => 'unauthorize'], 401);
        }
    }
}
