<?php

namespace App\Models;

class CarRentalOrder extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        'order_code',
        'car_name',
        'car_rental_id',
        'customer_id',
        'amount',
        'quantity',
        'start_date',
        'end_date',
        'payment_status',
        'payment_response',
        'payment_channel',
        'payment_type',
    ];
}
