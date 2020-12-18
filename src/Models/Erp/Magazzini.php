<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Company, Product, Primitive};
use Illuminate\Support\Facades\Cache;

class Magazzini extends Company
{
    public static function Magazzino()
    {
        $Magazzino = Cache::remember('Magazzino', 60*10, function () {
            return Company::where('rag_soc', 'Magazzino')->first()->id;
        });

        if(!Company::where('rag_soc', 'Magazzino')->exists())
        {
            return Company::create(['rag_soc' => 'Magazzino', 'fornitore' => 1])->id;
        }

        return $Magazzino;
    }

    public static function Ricambi()
    {
        $Ricambi = Cache::remember('Ricambi', 60*10, function () {
            return Company::where('rag_soc', 'Ricambi')->first()->id;
        });

        if(!Company::where('rag_soc', 'Ricambi')->exists())
        {
            return Company::create(['rag_soc' => 'Ricambi', 'fornitore' => 1])->id;
        }
        return $Ricambi;
    }

    public static function RicambiName()
    {
        return 'Ricambi';
    }

    public static function FinitiName()
    {
        return 'Finiti';
    }

    public static function SpedizioneName()
    {
        return 'Spedizione';
    }

    public static function Finiti()
    {
        $Finiti = Cache::remember('Finiti', 60*10, function () {
            return Company::where('rag_soc', 'Finiti')->first()->id;
        });

        if(!Company::where('rag_soc', 'Finiti')->exists())
        {
            return Company::create(['rag_soc' => 'Finiti', 'fornitore' => 1])->id;
        }
        return $Finiti;
    }

    public static function Spedizione()
    {
        $Spedizione = Cache::remember('Spedizione', 60*10, function () {
            return Company::where('rag_soc', 'Spedizione')->first()->id;
        });

        if(!Company::where('rag_soc', 'Spedizione')->exists())
        {
            return Company::create(['rag_soc' => 'Spedizione', 'fornitore' => 1])->id;
        }
        return $Spedizione;
    }

    public static function Production()
    {
        return [self::Magazzino(), self::Ricambi(), self::Finiti(), self::Spedizione()];
    }



}
