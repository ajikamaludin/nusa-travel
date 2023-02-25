<?php

namespace App\Models;

use App\Models\Traits\OrderAble;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class FastboatTrack extends Model
{
    use OrderAble;

    protected $ORDER_NAMES = ['source.name', 'destination.name']; // need to know if this works

    protected $fillable = [
        "fastboat_source_id",
        "fastboat_destination_id",
        "price",
        "capacity",
        "arrival_time",
        "departure_time",
        "is_publish",
    ];

    public function source() 
    {
        return $this->belongsTo(FastboatPlace::class, 'fastboat_source_id');
    }

    public function destination() 
    {
        return $this->belongsTo(FastboatPlace::class, 'fastboat_destination_id');
    }

    public function item()
    {
        return $this->hasMany(OrderItem::class, 'entity_id');
    }

    public function item_ordered()
    {
        return $this->hasMany(OrderItem::class, 'entity_id');
    }

    protected function arrivalTime(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => substr($value, 0, 5),
        );
    }

    protected function departureTime(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => substr($value, 0, 5),
        );
    }

    public function detail($date)
    {
        return "<p>$this->order_detail</p>
        <p>$this->arrival_time - $this->departure_time</p>
        <p>". Carbon::parse($date)->format('d-m-Y') ."</p>
        <p>@ ". number_format($this->price, '0', ',' ,' .') ."</p>";
    }
}
