<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            Log::debug("visitor", [$request->ip()]);
            $v->fill([
                'device' => $request->header('sec-ch-ua-mobile'),
                'platform' => $request->header('sec-ch-ua-platform'),
                'browser' => $request->header('sec-ch-ua'),
                'languages' => json_encode($request->header('accept-language')),
                'ip' => $request->ip(),
                'useragent' => $request->header('user-agent'),
            ]);
            $v->save();
        }));

        return $response;
    }
}
