<?php

namespace Jacofda\Klaxon\Models;

use Illuminate\Support\Facades\Cache;
use \Carbon\Carbon;
use \DB;
use Jacofda\Klaxon\Models\Erp\Magazzini;
use Jacofda\Klaxon\Models\Setting;;

class Store extends Primitive
{
    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


//SCOPEs
    public function scopeInterno($query)
    {
        $query = $query->whereIn('company_id', Magazzini::production());
    }

    public function scopeEsterno($query)
    {
        $query = $query->whereNotIn('company_id', Magazzini::production());
    }

    public function scopeMagazzino($query)
    {
        $query = $query->where('company_id', Magazzini::Magazzino());
    }

    public function scopeRicambi($query)
    {
        $query = $query->where('company_id', Magazzini::Ricambi());
    }

    public function scopeFiniti($query)
    {
        $query = $query->where('company_id', Magazzini::Finiti());
    }

    public function scopeSpedizione($query)
    {
        $query = $query->where('company_id', Magazzini::Spedizione());
    }

    public function scopeFornitore($query, $company_id)
    {
        $query = $query->where('company_id', $company_id);
    }

    public function scopeProdotto($query, $product_id)
    {
        $query = $query->where('product_id', $product_id);
    }


    public static function qtaLavoratore($product, $store)
    {
        $s = self::prodotto($product)->fornitore($store)->first();
        if($s)
        {
            return $s->qta;
        }
        return 0;
    }


    public static function Remove($product, $store, $qta)
    {
        $s = self::prodotto($product)->fornitore($store)->first();
        return $s->decrement('qta', $qta);
    }

    public static function Add($product, $store, $qta)
    {
        $s = self::prodotto($product)->fornitore($store)->first();
        if($s)
        {
            return $s->increment('qta', $qta);
        }

        return self::create([
                'product_id' => $product,
                'qta' => $qta,
                'company_id' => $store
            ]);

    }


}
