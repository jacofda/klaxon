<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Product, Primitive};
use Jacofda\Klaxon\Models\Erp\Order;

class Purchase extends Primitive
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
