<?php

namespace App\Models;

class FastboatPlace extends Model
{
    protected $cascadeDeletes = ['tracks', 'groups', 'pickups'];

    protected $fillable = [
        'name',
        'source'
    ];

    public function tracks()
    {
        return $this->hasMany(FastboatTrack::class);
    }

    public function sources()
    {
        return $this->hasMany(FastboatTrack::class, 'fastboat_source_id');
    }

    public function destinations()
    {
        return $this->hasMany(FastboatTrack::class, 'fastboat_destination_id');
    }

    public function groups()
    {
        return $this->hasMany(FastboatTrackOrder::class, 'fastboat_place_id');
    }

    public function pickups()
    {
        return $this->hasMany(FastboatPickup::class, 'source_id');
    }
}
