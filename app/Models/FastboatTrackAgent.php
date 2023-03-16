<?php

namespace App\Models;

class FastboatTrackAgent extends Model
{
    protected $fillable = [
        'fastboat_track_id',
        'customer_id',
        'price',
    ];
    public function tracks()
    {
        return $this->belongsTo(FastboatTrack::class, 'fastboat_track_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
