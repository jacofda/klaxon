<?php

namespace Jacofda\Klaxon\Models\Crm;

use Jacofda\Klaxon\Models\Product;

class Item extends Primitive
{
    public $timestamps = false;

//an item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
