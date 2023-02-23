<?php

namespace App\Models;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'entity_order',
        'entity_id',
        'description',
        'amount',
        'quantity',
        'date',
        'start_date',
        'end_date',
    ];

    public function item()
    {
        return $this->belongsTo($this->entity_order, 'entity_id');
    }
}
