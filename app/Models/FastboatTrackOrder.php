<?php

namespace App\Models;

class FastboatTrackOrder extends Model
{
    protected $fillable = [
        'fastboat_track_group_id',
        'fastboat_place_id',
        'order',
    ];
}
