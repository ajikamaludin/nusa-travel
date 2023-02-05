<?php

namespace App\Models;

class CarRental extends Model
{
    protected $cascadeDeletes = [];

    protected $fillable = [
        'name',
        'price',
        'description',
        'capacity',
        'luggage',
        'transmission',
        'cover_img_id',
        'is_publish',
    ];
}
