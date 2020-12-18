<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Company, Product, Primitive, Setting, Store};
use Jacofda\Klaxon\Models\Erp\{Check, Magazzini};

class Work extends Primitive
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function inputs()
    {
        return $this->belongsToMany(Product::class, 'product_work', 'work_id', 'input_id')->withPivot('qta');
    }

    public function checks()
    {
        return $this->morphMany(Check::class, 'checkable');
    }

    public function getComponentiAttribute()
    {
        $inputs = [];
        foreach ($this->inputs as $value) {

            $inputs[] = (object) [
                'product' => Product::find($value->id),
                'qta' => $value->pivot->qta
            ];
        }
        return (object) $inputs;
    }

    public static function inputQta($work, $input)
    {
        $r = \DB::table('product_work')->select('qta')->where('work_id', $work->id)->where('input_id', $input->id)->first();
        if($r)
        {
            return $r->qta;
        }
        return 0;
    }


    public static function ProductIsFromHome($company_id)
    {
        if($company_id == Magazzini::Magazzino())
        {
            return true;
        }
        return false;
    }

    public static function ProductIsNotFromHome($company_id)
    {
        if($company_id != Magazzini::Magazzino())
        {
            return true;
        }
        return false;
    }

    public function getIsDoneByHomeAttribute()
    {
        if($this->company_id == Setting::HomeId())
        {
            return Magazzini::Magazzino();
        }
        return false;
    }



}
