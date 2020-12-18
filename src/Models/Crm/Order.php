<?php

namespace Jacofda\Klaxon\Models\Crm;

use Jacofda\Klaxon\Models\{Product, Primitive};

class Order extends Primitive
{
    public function getUrlAttribute()
    {
        return url('orders/'.$this->id);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'order_item')->withPivot('qta');
    }
}
