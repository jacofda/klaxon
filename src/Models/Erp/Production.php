<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Company, Product, Primitive};
use Jacofda\Klaxon\Models\Erp\Order;

class Production extends Primitive
{
    public function input()
    {
        return $this->belongsTo(Product::class);
    }

    public function output()
    {
        return $this->belongsTo(Product::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


// GETTER
    public function getStatoAttribute()
    {
        return round(($this->input_qta_sent / $this->input_qta) * 100);
    }

    public function getBgAttribute()
    {
        if($this->stato == 0)
        {
            return 'danger';
        }
        elseif($this->stato <= 80 )
        {
            return 'primary';
        }
        return 'success';
    }

    public function getQtaFornitoreAttribute()
    {
        $mag_fornitore = $this->input->stores()->fornitore(Product::find($this->input_id)->company_id)->first();
        if(is_null($mag_fornitore))
        {
            return 0;
        }
        return $mag_fornitore->qta;
    }

    public function getIsAvailableAttribute()
    {
        if($this->qta_fornitore >= $this->input_qta)
        {
            return true;
        }

        if($this->input->qta_magazzino >= $this->input_qta)
        {
            return true;
        }

        return false;

    }

}
