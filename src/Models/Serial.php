<?php

namespace Jacofda\Klaxon\Models;

use Jacofda\Klaxon\Models\Erp\Order;
use Jacofda\Klaxon\Models\{Company, Product};

class Serial extends Primitive
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function erpOrder()
    // {
    //     return $this->belongsTo(Order::class, 'serials', 'id', 'erp_order_id');
    // }

}
