<?php

namespace App\Models;


class FastboatPlace extends Model
{
    protected $cascadeDeletes = ['tracks'];

    protected $fillable = [
        'name',
    ];

    public function tracks()
    {
        return $this->hasMany(FastboatTrack::class);
    }
}
