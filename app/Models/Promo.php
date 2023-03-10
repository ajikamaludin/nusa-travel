<?php

namespace App\Models;

class Promo extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
        'cover_image',
        'discount_percent',
        'discount_amount',
        'available_start_date',
        'available_end_date',
        'order_start_date',
        'order_end_date',
        'user_perday_limit',
        'order_perday_limit',
        'entity_type',
        'entity_id',
    ];
}
