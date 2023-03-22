<?php

namespace App\Models;

class FastboatPickup extends Model
{
    protected $fillable = [
        'name',
        'source_id',
        'car_rental_id',
    ];

    public function source()
    {
        return $this->belongsTo(FastboatPlace::class, 'source_id');
    }

    public function car()
    {
        return $this->belongsTo(CarRental::class, 'car_rental_id');
    }
}
