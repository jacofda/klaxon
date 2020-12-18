<?php

namespace Jacofda\Klaxon\Models\Fe;

use \Carbon\Carbon;
use \Storage;
use Illuminate\Database\Eloquent\Model;

use Jacofda\Klaxon\Models\{Cost, Exemption, Expense, Invoice, Media, Product, Setting};

class Primitive extends Model
{

    public function decimal($n)
    {
        return number_format(floatval($n), 2, '.', '');
    }

    public function dataFromXml($xml)
    {
        return Carbon::parse($xml->FatturaElettronicaBody->DatiGenerali->DatiGeneraliDocumento->Data);
    }

}
