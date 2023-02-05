<?php

namespace App\Models;

class Post extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        "title",
        "body",
        "meta_tag",
    ];
}
