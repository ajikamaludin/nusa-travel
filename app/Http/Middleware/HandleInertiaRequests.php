<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = null;
        if(Auth::guard('web')->check()) {
            $user = $request->user() instanceof User ? $request->user()->load(['role.permissions']) : $request->user();
        }
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
        ]);
    }
}
