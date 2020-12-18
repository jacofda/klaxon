<?php

namespace Jacofda\Klaxon\Facades;

use Illuminate\Support\Facades\Facade;

class Klaxon extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'klaxon';
    }
}
