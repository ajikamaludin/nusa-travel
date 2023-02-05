<?php

namespace App\Models;


class FastboatTrack extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        "fastboat_source_id",
        "fastboat_destination_id",
        "price",
        "capacity",
        "arrival_time",
        "departure_time",
        "is_publish",
    ];
}
