<?php

namespace Jacofda\Klaxon\Models\Crm;

use Jacofda\Klaxon\Models\{Product, Primitive};

class ProductType extends Primitive
{
    public $timestamps = false;

    protected $table = 'product_types';

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
