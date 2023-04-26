<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public static $instance;

    protected $fillalble = [
        'key',
        'value',
        'type',
    ];

    public static function getInstance(): Setting
    {
        if (self::$instance == null) {
            self::$instance = new Setting;
            if (Cache::has('settings')) {
                self::$instance->setting = Cache::get('settings');
            } else {
                self::$instance->setting = Setting::all();
                Cache::put('settings', self::$instance->setting, now()->addDay());
            }

        }

        return self::$instance;
    }

    public function getValue($key): string|null
    {
        $v = self::getInstance();

        return $v->setting->where('key', $key)->value('value');
    }

    public function getSlides(): array
    {
        $v = self::getInstance();

        return $v->setting->filter(function ($item) {
            return false !== strpos($item->key, 'G_LANDING_SLIDE_');
        })->pluck('value')
            ->toArray();
    }

    public static function getByKey($key)
    {
        return Setting::where('key', $key)->value('value');
    }
}
