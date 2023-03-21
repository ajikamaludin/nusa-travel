<?php

namespace App\Models;

class FastboatTrackAgent extends Model
{
    protected $fillable = [
        'fastboat_track_id',
        'customer_id',
        'price',
        'fast_track_group_agents_id',
    ];

    public function tracks()
    {
        return $this->belongsTo(FastboatTrack::class, 'fastboat_track_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function fastboat()
    {
        return $this->belongsTo(Fastboat::class);
    }

    public function places()
    {
        return $this->hasMany(FastboatTrackOrder::class);
    }
}
