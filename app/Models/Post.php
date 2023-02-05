<?php

namespace App\Models;

class Post extends Model
{
    protected $cascadeDeletes = [];

    protected $fillable = [
        'slug',
        'title',
        'body',
        'meta_tag',
    ];
}
