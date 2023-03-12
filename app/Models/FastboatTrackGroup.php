<?php

namespace App\Models;

class FastboatTrackGroup extends Model
{
    protected $fillable = [
        'fastboat_id',
        'name',
    ];

    public function fastboat()
    {
        return $this->belongsTo(Fastboat::class);
    }

    public function tracks()
    {
        return $this->hasMany(FastboatTrack::class);
    }

    public function places()
    {
        return $this->hasMany(FastboatTrackOrder::class)->withTrashed();
    }
}
