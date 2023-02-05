<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use React\EventLoop\Loop;
use function React\Async\async;

class VisitorCounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        

        Loop::addTimer(0.1, async(function () use($request) {
            $v = Visitor::getInstance();
            $v->fill([
                'device' => $request->visitor()->device(),
                'platform' => $request->visitor()->platform(),
                'browser' => $request->visitor()->browser(),
                'languages' => json_encode($request->visitor()->languages()),
                'ip' => $request->visitor()->ip(),
                'useragent' => $request->visitor()->useragent(),
            ]);
            $v->save();
        }));

        return $response;
    }
}
