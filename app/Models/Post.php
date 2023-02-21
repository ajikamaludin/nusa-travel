<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    protected $cascadeDeletes = [];

    const DRAFT = 0;
    const PUBLISH = 1;

    protected $fillable = [
        'slug',
        'title',
        'body',
        'meta_tag',
        'cover_image',
        'is_publish'
    ];

    protected function publish(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                self::DRAFT => 'Draft',
                self::PUBLISH => 'Publish'
            ][$this->is_publish],
        );
    }

}
