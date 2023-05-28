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

    public function getEnablePayment()
    {
        $setting = self::getInstance();
        $midtrans = $setting->setting->where('key', 'midtrans_enable')->value('value');
        $doku = $setting->setting->where('key', 'DOKU_ENABLE')->value('value');

        $payments = collect();
        if ($midtrans == 1) {
            $logo = $setting->setting->where('key', 'midtrans_logo')->first();
            $payments->add(['name' => self::PAYMENT_MIDTRANS, 'logo' => $logo->url]);
        }

        if ($doku == 1) {
            $logo = $setting->setting->where('key', 'DOKU_LOGO')->first();
            $payments->add(['name' => self::PAYMENT_DOKU, 'logo' => $logo->url]);

            // enable credit card direct payment page
            // $payments->add(['name' => self::PAYMENT_DOKU_CREDIT, 'logo' => 'CARD_CREDIT']);
        }

        return $payments->toArray();
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
