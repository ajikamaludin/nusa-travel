<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    const PAYMENT_MIDTRANS = 'midtrans';

    const PAYMENT_DOKU = 'DOKU';

    const PAYMENT_DOKU_CREDIT = 'DOKU_CREDIT_CARD';

    const DEPOSITE_AGENT = 'DEPOSITE AGENT';

    public static $instance;

    protected $fillalble = [
        'key',
        'value',
        'type',
    ];

    protected $appends = [
        'url',
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

    protected function url(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->type == 'image') {
                return asset($this->value);
            }

            return '';
        });
    }
}
