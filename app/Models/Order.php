<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Order extends Model
{
    const TYPE_CART = 0;

    const TYPE_ORDER = 1;

    const PAYMENT_SUCESS = 1;

    const PAYMENT_ERROR = 2;

    const PAYMENT_PENDING = 3;

    protected $cascadeDeletes = [];

    protected $fillable = [
        'order_code',
        'customer_id',
        'total_amount',
        'date',
        'start_date',
        'end_date',
        'order_type',
        'payment_token',
        'payment_status',
        'payment_response',
        'payment_channel',
        'payment_type',
        'description',
        'total_discount',
        'pickup',
    ];

    protected $appends = [
        'order_date_formated',
        'payment_status_text',
        'payment_status_color',
        'passenger_name',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promos()
    {
        return $this->hasMany(OrderPromo::class);
    }

    public static function generateCode()
    {
        return Str::upper(Str::random(6)) . now()->format('dmY');
    }

    protected function paymentStatusColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                return [
                    1 => 'text-green-500',
                    2 => 'text-red-600',
                    3 => 'text-yellow-500',
                    '' => 'text-black',
                ][$this->payment_status];
            },
        );
    }

    protected function paymentStatusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                return [
                    1 => 'PAID',
                    2 => 'ERROR',
                    3 => 'PENDING',
                    '' => 'UNPAID',
                ][$this->payment_status];
            },
        );
    }

    protected function orderDateFormated(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Carbon::parse($this->date)->format('d-m-Y');
            },
        );
    }

    protected function discountFormated(): Attribute
    {
        return Attribute::make(
            get: function () {
                return number_format($this->total_discount, 0, ',', '.');
            }
        );
    }

    protected function amountFormated(): Attribute
    {
        return Attribute::make(
            get: function () {
                return number_format($this->total_amount, 0, ',', '.');
            }
        );
    }

    protected function passengerName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $item = $this->items()->first();
                if ($item->entity_order == FastboatTrack::class) {
                    return $item->passengers()->first()->name;
                }

                return $this->customer->name;
            }
        );
    }
}
