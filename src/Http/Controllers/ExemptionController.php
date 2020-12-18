<?php

namespace Jacofda\Klaxon\Http\Controllers;

class ExemptionController extends Controller
{
    public function getIva(Exemption $exemption)
    {
        return $exemption->perc;
    }
}
