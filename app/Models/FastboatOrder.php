<?php

namespace App\Models;

class FastboatOrder extends Model
{
    protected $cascadeDeletes = [];
    protected $fillable = [
        "order_code",
        "track_name",
        "fastboat_track_id",
        "customer_id",
        "amount",
        "quantity",
        "date",
        "arrival_time",
        "departure_time",
        "payment_status",
        "payment_response",
        "payment_channel",
        "payment_type",
    ];
}
