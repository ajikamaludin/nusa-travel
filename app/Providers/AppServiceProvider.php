<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // for optimize in development log every query
        if (app()->isProduction() == false) {
            DB::listen(function ($query) {
                Log::info(
                    $query->sql,
                    [
                        'bindings' => $query->bindings,
                        'time' => $query->time,
                        'connectionName' => $query->connectionName,
                    ]
                );
            });
        }

        // just for optional provider on web app run
        try {
            // shared setting
            if (Cache::has('has-setting-table')) {
                View::share('setting', Setting::getInstance());
            } else {
                if (Schema::hasTable('settings')) {
                    Cache::put('has-setting-table', true);
                    View::share('setting', Setting::getInstance());
                }
            }
        } catch (\Exception $r) {
        }
    }
}
