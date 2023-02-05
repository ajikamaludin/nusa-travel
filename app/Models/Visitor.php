<?php

namespace App\Models;

use App\Models\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory, HasUuids, UserTrackable;

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
}
