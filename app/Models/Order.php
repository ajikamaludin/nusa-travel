<?php

namespace App\Models;

class Order extends Model
{
    protected $fillable = [
        "order_code",
        "customer_id",
        "total_amount",
        "date",
        "start_date",
        "end_date",
        "order_type",
        "payment_status",
        "payment_response",
        "payment_channel",
        "payment_type",
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


}
