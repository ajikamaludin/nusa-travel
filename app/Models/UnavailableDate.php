<?php

namespace App\Models;

class UnavailableDate extends Model
{
    protected $fillable = [
        'close_date',
        'fastboat_track_id',
        'additional_info',
    ];
}
