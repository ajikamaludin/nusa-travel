<?php

namespace App\Services;

use Closure;
use function React\Async\async;
use React\EventLoop\Loop;

class AsyncService
{
    public static function async(Closure $closure)
    {
        Loop::addTimer(0.1, async(function () use ($closure) {
            $closure();
        }));
    }
}
