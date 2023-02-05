<?php

namespace App\Models;

class Customer extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        "name",
        "email",
        "phone",
        "password",
        "address",
        "nation",
    ];
}
