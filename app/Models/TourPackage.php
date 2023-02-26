<?php

namespace App\Models;

use App\Models\Traits\OrderAble;

class TourPackage extends Model
{
    use OrderAble;

    public $ORDER_NAMES = ['name', 'title'];

    protected $cascadeDeletes = [];

    protected $fillable = [
        'name',
        'title',
        'body',
        'meta_tag',
        'price',
        'cover_img_id',
        'is_publish',
    ];
}
