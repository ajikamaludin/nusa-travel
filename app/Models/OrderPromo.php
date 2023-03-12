<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function promoFormated(): Attribute
    {
        return Attribute::make(
            get: function () {
                return number_format($this->promo_amount, 0, ',', '.');
            }
        );
    }
}
