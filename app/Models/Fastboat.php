<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Fastboat extends Model
{
    protected $cascadeDeletes = ['group'];

    protected $fillable = [
        'id',
        'number',
        'name',
        'description',
        'capacity',
        'cover_image',
        'data_source',
    ];

    protected $appends = ['cover_url'];

    public function coverUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset($this->cover_image),
        );
    }

    public function group()
    {
        return $this->hasMany(FastboatTrackGroup::class);
    }
}
