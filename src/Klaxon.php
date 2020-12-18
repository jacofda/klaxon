<?php

namespace Jacofda\Klaxon;

use Illuminate\Support\Facades\Facade;

class Klaxon extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'klaxon';
    }

}
