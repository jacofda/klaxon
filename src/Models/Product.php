<?php

namespace Jacofda\Klaxon\Models;

use Jacofda\Klaxon\Models\Crm\{ProductCategory, ProductType};
use Jacofda\Klaxon\Models\Erp\{Group, Purchase, Magazzini, Work};
use Jacofda\Klaxon\Models\Store;

class Product extends Primitive
{

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }


    public function work()
    {
        return $this->hasOne(Work::class);
    }

    public function components()
    {
        return $this->work()->first()->inputs();
    }


    public function children($arr = null)
    {
        if(is_null($arr)) { $arr = []; }

        $arr[$this->id] = $this->components()->get();

        foreach($this->components()->get() as $product)
        {
            if($product->work()->exists()) //&& !(array_key_exists($arr[$product->id]))
            {
                $arr[$product->id] = $product->components()->get();
            }
        }

        foreach($this->components()->get() as $product)
        {
            if($product->work()->exists())
            {
                foreach($product->components()->get() as $p)
                {
                    if($p->work()->exists())
                    {
                        return $p->children($arr);
                    }
                }
            }
        }
        return $arr;
    }


    public function figli($qta = null)
    {
        $arr2 = []; $arr3 = [];

        $r1 = $this->work()->first()->inputs()->addSelect('products.id', 'product_work.qta', 'product_work.work_id')->get();
        $arr = $this->mutateArray((clone $r1)->toArray(), $qta);

        foreach($r1 as $p1)
        {
            if($p1->work()->exists())
            {
                $r2 = $p1->work()->first()->inputs()->addSelect('products.id', 'product_work.qta', 'product_work.work_id')->get();
                $arr2 = $this->mutateArray((clone $r2)->toArray(), $qta);
                foreach($r2 as $p2)
                {
                    if($p2->work()->exists())
                    {
                        $r3 = $p2->work()->first()->inputs()->addSelect('products.id', 'product_work.qta', 'product_work.work_id')->get();
                        $arr3 = $this->mutateArray((clone $r3)->toArray(), $qta);
                        $arr += $arr3;
                    }
                }
                $arr += $arr2;
            }
        }
        return $arr;
    }

    public function mutateArray($arr, $qta)
    {
        $result = [];
        foreach($arr as $value)
        {
            if(!in_array($value['id'], $result))
            {
                $id = $value['id'];
                unset($value['id']);
                unset($value['pivot']);
                $value['multiplier'] = $qta;
                $result[$id] = $value;
            }
        }
        return $result;
    }

    public function getChildrenStringAttribute()
    {
        $r = $this->work()->first()->inputs()->pluck('products.id')->toArray();
        return implode(',', $r);
    }


    public function getIsMultiLevelAttribute()
    {
        if(count($this->children()) > 1)
        {
            return true;
        }
        return false;
    }




// SCOPE
    public function scopeAcquistabili($query)
    {
        $query = $query->where('acquistabile', true);
    }

    public function scopeAssemblabili($query)
    {
        $query = $query->where('acquistabile', false);
    }

    public function scopeVendibili($query)
    {
        $query = $query->whereNotNull('prezzo_retail');
    }

    public function scopeRequiresn($query)
    {
        $query = $query->where('has_sn', true);
    }



    public static function filter($data)
    {
        $query = self::query();

        if($data->has('acquistabile'))
        {
            if($data['acquistabile'] == '1')
            {
                $query = $query->acquistabili();
            }
            else
            {
                $query = $query->assemblabili();
            }
        }

        if($data->get('id'))
        {
            $query = $query->where('id', $data['id']);
        }

        if($data->get('sort'))
        {
            $arr = explode('|', $data->sort);
            $field = $arr[0];
            $value = $arr[1];
            $query = $query->orderBy($field, $value);
        }

        return $query;
    }

//STATIC
    public static function SNids()
    {
        return self::requiresn()->pluck('id')->toArray();
    }

//GETTER

    public function getDefaultStoreAttribute()
    {
        if(in_array($this->group_id, Group::Ricambi()))
        {
            return Magazzini::Ricambi();
        }
        return Magazzini::Finiti();
    }

    public function getDefaultStoreNameAttribute()
    {
        if(in_array($this->group_id, Group::Ricambi()))
        {
            return Magazzini::RicambiName();
        }
        return Magazzini::FinitiName();
    }


    public function getNameAttribute()
    {
        $lang = session()->get('locale');

        if($lang == 'it')
        {
            return $this->nome_it;
        }

        return $this->nome_en;
    }

    public function getQtaSpedizioneAttribute()
    {
        $p = $this->stores()->spedizione()->first();
        if($p)
        {
            return $p->qta;
        }
        return 0;
    }

    public function getQtaMagazzinoAttribute()
    {
        $p = $this->stores()->magazzino()->first();
        if($p)
        {
            return $p->qta;
        }
        return 0;
    }

    public function getQtaRicambiAttribute()
    {
        $p = $this->stores()->ricambi()->first();
        if($p)
        {
            return $p->qta;
        }
        return 0;
    }

    public function getQtaFinitiAttribute()
    {
        $p = $this->stores()->finiti()->first();
        if($p)
        {
            return $p->qta;
        }
        return 0;
    }

    public function getOrderedAttribute()
    {
        if($this->purchases()->where('qta_arrived', 0)->exists()){
            return $this->purchases()->where('qta_arrived', 0)->sum('qta');
        }
        return 0;
    }

//PRICES
    public function getCostoFornituraFormattedAttribute()
    {
        return '€ '. number_format($this->costo_fornitura, 2, ',', '.');
    }

}
