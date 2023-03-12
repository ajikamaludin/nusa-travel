<?php

namespace App\Models;

class FastboatPlace extends Model
{
    protected $cascadeDeletes = [];

    protected $fillable = [
        'name',
    ];

    public function tracks()
    {
        return $this->hasMany(FastboatTrack::class);
    }
}
