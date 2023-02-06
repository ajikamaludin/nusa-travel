<?php

namespace App\Models;

class TourPackagePrice extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        'tour_package_id',
        'quantity',
        'price',
    ];
}
