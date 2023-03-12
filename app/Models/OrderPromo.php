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

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
}
