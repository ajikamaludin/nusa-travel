<?php

namespace App\Models;

class TourPackageOrder extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        'order_code',
        'package_name',
        'tour_package_id',
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
