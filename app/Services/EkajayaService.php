<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class EkajayaService
{
    public static function search($source, $destination, $date, $ways)
    {
        $setting = Setting::getInstance();
        Log::info('setting', [$setting->getValue('EKAJAYA_HOST'), $setting->getValue('EKAJAYA_APIKEY')]);

        $key = $ways.'|'.$source.'_'.$destination.':'.$date;
        // TODO:
        if(! Cache::has($key)) {
            // cached for 1 hour, if has cache skip step below
            Cache::put($key, true, now()->addHour());
            Log::info('caching...');
            // call api ekajaya for search
            // if found result than record/upsert to db: tracks, capacities
            // if no result fount than check db , if any remove record
        }
        Log::info('process...', [$key]);
    }
}
