<?php

namespace App\Models;

use App\Models\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory, HasUuids, UserTrackable;

    public static $instance;

    public $visited = '';

    protected $fillable = [
        'related_model',
        'related_model_id',
        'device',
        'platform',
        'browser',
        'languages',
        'ip',
        'useragent',
    ];

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Visitor();
        }
        return self::$instance;
    }

    public static function track($data) {
        $v = self::getInstance();
        $v->related_model = $data[0];
        $v->related_model_id = $data[1];
    }
}
