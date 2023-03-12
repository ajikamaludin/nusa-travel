<?php

namespace App\Models;

class FastboatTrackOrder extends Model //order here mean as a sorting
{
    protected $fillable = [
        'fastboat_track_group_id',
        'fastboat_place_id',
        'order',
    ];

    public function place()
    {
        return $this->belongsTo(FastboatPlace::class, 'fastboat_place_id')->withTrashed();
    }
}
