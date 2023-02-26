<?php

namespace App\Models;

use App\Models\Traits\OrderAble;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class CarRental extends Model
{
    use OrderAble;

    protected $ORDER_NAMES = ['name', 'description'];

    const UNREADY = 0;
    const READY = 1;

    protected $cascadeDeletes = [];

    protected $fillable = [
        'name',
        'price',
        'description',
        'capacity',
        'luggage',
        'transmission',
        'cover_image',
        'is_publish',
        'car_owned'
    ];

    protected $appends = ['image_url'];

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset($this->cover_image),
        );
    }

    public function detail($date)
    {
        return "<p>$this->name (Car Rental)</p>
        <p>$this->description</p>
        <p>". Carbon::parse($date)->format('d-m-Y') ."</p>
        <p>@ ". number_format($this->price, '0', ',' ,' .') ."</p>";
    }
}
