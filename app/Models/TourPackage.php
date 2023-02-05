<?php

namespace App\Models;

class TourPackage extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        "name",
        "title",
        "body",
        "meta_tag",
        "price",
        "cover_img_id",
        "is_publish",
    ];
}
