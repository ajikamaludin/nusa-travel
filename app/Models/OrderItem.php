<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected $appends = ['detail'];

    public function item()
    {
        return $this->belongsTo((string) $this->entity_order, 'entity_id');
    }

    protected function detail(): Attribute
    {
        return Attribute::make(
            get: function () {
                $detail = '';
                if($this->item instanceof FastboatTrack) {
                    $detail = $this->item->detail($this->date);
                }
                if($this->item instanceof CarRental) {
                    $detail = $this->item->detail($this->date);
                }

                return $detail;
            },
        );
    }
}
