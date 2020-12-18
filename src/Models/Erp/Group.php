<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Product, Primitive};
use Illuminate\Support\Facades\Cache;

class Group extends Primitive
{
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function Ricambi()
    {
        $GruppoRicambi = Cache::remember('GruppoRicambi', 60*10, function () {
            return [self::where('nome', 'HUB-BATTERIA')->first()->id,
                    self::where('nome', 'IMB-IMBALLAGGI')->first()->id,
                    self::where('nome', 'HUB-CAVALLETTO')->first()->id];
        });

        return $GruppoRicambi;
    }


}
