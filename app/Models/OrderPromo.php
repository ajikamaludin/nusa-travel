<?php

namespace App\Models;

class OrderPromo extends Model
{
    protected $fillable = [
        'order_id',
        'promo_id',
        'promo_code',
        'promo_amount',
        'description',
    ];
}
