<?php

namespace App\Models;

class FastboatOrder extends Model
{
    protected $cascadeDeletes = [];

    const UNPAID = 'UNPAID';
    const PAID = 'PAID';
    const FAILED = 'FAILED';
    const PENDING = 'PENDING';

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

        "payment_token",
        "payment_status",
        "payment_response",
        "payment_channel",
        "payment_type",
    ];

    public function track()
    {
        return $this->belongsTo(FastboatTrack::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
