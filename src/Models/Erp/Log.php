<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Company, Product, Primitive};
use Jacofda\Klaxon\Models\Erp\{Magazzini, Order};

class Log extends Primitive
{
    protected $table = 'erp_logs_quantity';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function from()
    {
        return $this->belongsTo(Company::class, 'from_company_id');
    }

    public function to()
    {
        return $this->belongsTo(Company::class, 'to_company_id');
    }

    public static function Record($before, $after, $qta, $from = null, $to = null, $order, $product)
    {
        Log::create([
            'before' => $before,
            'after' => $after,
            'qta' => $qta,
            'from_company_id' => $from,
            'to_company_id' => $to,
            'order_id' => $order,
            'product_id' => $product
        ]);
    }


}
