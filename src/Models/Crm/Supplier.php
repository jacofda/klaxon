<?php

namespace Jacofda\Klaxon\Models\Crm;

use Jacofda\Klaxon\Models\{Company, Primitive};

class Supplier extends Primitive
{
    public $timestamps = false;

    public function type()
    {
        return $this->hasMany(Company::class);
    }
}
