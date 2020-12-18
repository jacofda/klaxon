<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Company, Product, Primitive, Setting, Store};
use Jacofda\Klaxon\Models\Erp\{Assembly, Order, Magazzini};

class Shipping extends Primitive
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}
