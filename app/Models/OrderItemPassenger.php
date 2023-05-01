<?php

namespace App\Models;

class OrderItemPassenger extends Model
{
    const TYPE_PERSON = 0;

    const TYPE_INFANT = 1;

    protected $fillable = [
        'order_item_id',
        'customer_id',
        'nation',
        'national_id',
        'name',
        'type',
    ];

    public function item()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
