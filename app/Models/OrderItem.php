<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

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
        'dropoff',
        'dropoff_id',
        'pickup',
        'pickup_id',
        'globaltix_response_json', //to trace globaltix order response
        'item_addtional_info_json', //to trace what item ordered detail
    ];

    protected $appends = ['detail'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item()
    {
        return $this->belongsTo((string) $this->entity_order, 'entity_id')->withTrashed();
    }

    public function passengers()
    {
        return $this->hasMany(OrderItemPassenger::class);
    }

    protected function detail(): Attribute
    {
        return Attribute::make(
            get: function () {
                $detail = '';
                if ($this->item instanceof FastboatTrack) {
                    $detail = $this->item->detail($this->date, $this->dropoff);
                }
                if ($this->item instanceof CarRental) {
                    $detail = $this->item->detail($this->date);
                }
                if ($this->item instanceof TourPackage) {
                    $detail = $this->item->detail($this->date, $this->amount);
                }

                return $detail;
            },
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: function () {
                return number_format($this->amount, 0, ',', '.');
            }
        );
    }

    protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: function () {
                return number_format($this->amount * $this->quantity, 0, ',', '.');
            }
        );
    }

    protected function dateFormated(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Carbon::parse($this->date)->format('d-m-Y');
            }
        );
    }

    protected function dateDotFormated(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Carbon::parse($this->date)->format('d.m.Y');
            }
        );
    }
}
