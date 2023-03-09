<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait OrderAble
{
    public function orderDetail(): Attribute
    {
        return Attribute::make(
            get: function () {
                $name = '';
                foreach ($this->ORDER_NAMES as $order) {
                    $arr = explode('.', $order);
                    if (count($arr) >= 2) {
                        $name .= $this->{$arr[0]}->{$arr[1]}.' - ';
                    } else {
                        $name .= $this->{$order};
                    }
                }
                $name = trim($name, ' - ');

                return $name;
            },
        );
    }
}
