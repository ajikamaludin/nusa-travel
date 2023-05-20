<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use function React\Async\async;
use React\EventLoop\Loop;

class VisitorCounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = 'en';
        if (session()->has('locale')) {
            $locale = session('locale');
        } else {
            session(['locale' => 'en']);
        }

        app()->setLocale($locale);

        URL::defaults(['locale' => $locale]);

        $response = $next($request);

        Loop::addTimer(1, async(function () use ($request) {
            $v = Visitor::getInstance();
            Log::debug('visitor', [$request->ip()]);
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
