<?php

namespace App\Models;

class Tag extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        "name"
    ];
}
