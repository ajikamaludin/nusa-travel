<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Auth;
use Closure;
use Illuminate\Http\Request;
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

        if(! empty($agent) && ! empty($token)) {
            Auth::guard('authtoken')->setUser($agent);

            return $next($request);
        }else {
            return response('you are unauthorize', 404);
        }

    }
}
