<?php

namespace App\Models;

class FastboatTrackAgent extends Model
{
    protected $cascadeDeletes = ['group'];

    protected $fillable = [
        'fastboat_track_agent_group_id',
        'fastboat_track_id',
        'customer_id',
        'price',
        'data_source',
    ];

    public function group()
    {
        return $this->belongsTo(FastboatTrackGroupAgent::class, 'fastboat_track_agent_group_id');
    }

    public function tracks()
    {
        return $this->belongsTo(FastboatTrack::class, 'fastboat_track_id');
    }

    public function track()
    {
        return $this->belongsTo(FastboatTrack::class, 'fastboat_track_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
