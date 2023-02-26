<?php

namespace App\Models;

use App\Models\Traits\OrderAble;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class TourPackage extends Model
{
    use OrderAble;

    const DRAFT = 0;
    const PUBLISH = 1;

    public $ORDER_NAMES = ['name', 'title'];

    protected $cascadeDeletes = [];

    protected $fillable = [
        'slug',
        'name',
        'title',
        'body',
        'meta_tag',
        'price',
        'cover_image',
        'is_publish',
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
        return "<p> $this->name ( Tour Packages )</p>
        <p>$this->title</p>
        <p>". Carbon::parse($date)->format('d-m-Y') ."</p>";
        // <p>@ ". number_format($this->price, '0', ',' ,' .') ."</p>";
    }

    public function images() 
    {
        return $this->hasMany(ModelImage::class, 'related_id');
    }

    public function prices()
    {
        return $this->hasMany(TourPackagePrice::class);
    }
}
