<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public static $instance;

    protected $fillalble = [
        'key',
        'value',
        'type'
    ];

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Setting();
            self::$instance->setting = Setting::all();
        }
        return self::$instance;
    }

    public function getValue($key) {
        $v = self::getInstance();
        return $v->setting->where('key', $key)->first()->value;
    }

    public function getSlides() {
        $v = self::getInstance();
        return $v->setting->filter(function($item) {
            return false !== strpos($item->key, 'G_LANDING_SLIDE_');
        })->pluck('value');
    }
}
