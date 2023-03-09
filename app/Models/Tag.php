<?php

namespace App\Models;

class Tag extends Model
{
    protected $cascadeDeletes = [];

    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->hasManyThrough(
            Post::class,
            PostTag::class,
            'id',
            'post_id',
            'id',
            'tag_ig'
        );
    }
}
