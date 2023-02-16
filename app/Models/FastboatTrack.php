<?php

namespace App\Models;


class FastboatTrack extends Model
{
    protected $cascadeDeletes = ['orders'];

    protected $fillable = [
        "fastboat_source_id",
        "fastboat_destination_id",
        "price",
        "capacity",
        "arrival_time",
        "departure_time",
        "is_publish",
    ];

    public function source() 
    {
        return $this->belongsTo(FastboatPlace::class, 'fastboat_source_id');
    }

    public function destination() 
    {
        return $this->belongsTo(FastboatPlace::class, 'fastboat_destination_id');
    }

    public function orders()
    {
        return $this->hasMany(FastboatOrder::class);
    }
}
