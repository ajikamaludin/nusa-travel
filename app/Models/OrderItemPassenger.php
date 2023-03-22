<?php

namespace App\Models;

class OrderItemPassenger extends Model
{
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
