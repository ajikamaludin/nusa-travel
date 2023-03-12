<?php

namespace App\Models;

class Promo extends Model
{
    const PROMO_ACTIVE = 1;

    const PROMO_DEACTIVE = 0;

    const TYPE_AMOUNT = 0;

    const TYPE_PERCENT = 1;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
        'cover_image',
        'discount_type',
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
