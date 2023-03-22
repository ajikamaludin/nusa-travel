<?php

namespace App\Models;

class FastboatTrackGroupAgent extends Model
{
    protected $cascadeDeletes = ['tracksAgent'];

    protected $fillable = [
        'fastboat_track_group_id',
        'customer_id',
    ];

    public function trackGroup()
    {
        return $this->belongsTo(FastboatTrackGroup::class, 'fastboat_track_group_id');
    }

    public function groupcustomer()
    {
        return $this->belongsTo(FastboatTrackAgent::class, 'customer_id');
    }

    public function grouptrack()
    {
        return $this->belongsTo(FastboatTrackAgent::class, 'fastboat_track_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tracksAgent()
    {
        return $this->hasMany(FastboatTrackAgent::class, 'fastboat_track_group_agents_id');
    }
}
