<?php

namespace Jacofda\Klaxon\Models;

class Exemption extends Primitive
{
    public $timestamps = false;

    public function getDirectoryAttribute()
    {
        return 'editor';
    }
}
