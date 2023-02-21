<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait OrderAble
{
    protected function orderName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $name = '';
                foreach ($this->ORDER_NAMES as $order) {
                    $name .=  $this->{$order};
                }
            },
        );
    }
}