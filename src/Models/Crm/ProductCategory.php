<?php

namespace Jacofda\Klaxon\Models\Crm;

use Jacofda\Klaxon\Models\{Product, Primitive};

class ProductCategory extends Primitive
{
    public $timestamps = false;
    protected $table = 'product_categories';

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
