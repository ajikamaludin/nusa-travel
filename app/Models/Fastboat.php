<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Fastboat extends Model
{
    protected $fillable = [
        'number',
        'name',
        'description',
        'capacity',
        'cover_image',
    ];

    protected $appends = ['cover_url'];

    public function coverUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset($this->cover_image),
        );
    }
}
