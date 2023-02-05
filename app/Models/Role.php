<?php

namespace App\Models;

class Role extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        "name"
    ];
}
