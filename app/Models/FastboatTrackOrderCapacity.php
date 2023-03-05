<?php

namespace App\Models;

class FastboatTrackOrderCapacity extends Model
{
    protected $fillable = [
        'fastboat_track_group_id',
        'fastboat_source_id',
        'fastboat_destination_id',
        'date',
        'capacity',
    ];
}
