<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Invoice, Product, Primitive, Serial};

class Order extends Primitive
{
    protected $table = 'erp_orders';

    public function getUrlAttribute()
    {
        return url('erp/orders/'.strtolower(str_plural($this->type)).'/'.$this->id);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function assemblies()
    {
        return $this->hasMany(Assembly::class);
    }

    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }

    public function checklists()
    {
        return $this->belongsToMany(Check::class, 'erp_order_checklist', 'erp_order_id', 'check_id')->withPivot('status');
    }

    public function invoices()
    {
        return $this->morphToMany(Invoice::class, 'invoiceable');
    }

    public function serials()
    {
        return $this->hasMany(Serial::class, 'erp_order_id');
    }


//SCOPES
    public function scopeVendite($query)
    {
        $query = $query->where('type', 'Assembly');
    }

    public function scopeAcquisti($query)
    {
        $query = $query->where('type', 'Purchase');
    }

    public function scopeLavorazioni($query)
    {
        $query = $query->where('type', 'Production');
    }

    public function scopeSpedizioni($query)
    {
        $query = $query->where('type', 'Shipping');
    }


//GETTER

    public function getCheckListStatusAttribute()
    {
        if($this->checklists()->exists())
        {
            $count = 0;$done = 0;
            foreach($this->checklists as $check)
            {
                $count++;
                $done += $check->pivot->status;
            }

            return round(($done/$count)*100);
        }
        return 0;
    }

    public function getShippingAllQtaAvailableAttribute()
    {
        foreach($this->shippings as $item)
        {
            if($item->qta == 0)
            {
                return false;
            }
            if($item->product->qta_spedizione < $item->qta)
            {
                return false;
            }
        }
        return true;
    }

    public function getAssemblyOrderShippingAttribute()
    {
        $orders = [];
        foreach($this->shippings as $shipping)
        {
            if(!in_array($shipping->assembly->order_id, $orders))
            {
                $orders[$shipping->assembly->order_id][] = $shipping;
            }
            else
            {
                $orders[$shipping->assembly->order_id][] = $shipping;
            }
        }
        return $orders;
    }

    public function getAssemblyOrderInShippingAttribute()
    {
        $orders = [];
        foreach($this->shippings as $shipping)
        {
            if(!in_array($shipping->assembly->order_id, $orders))
            {
                $orders[] = $shipping->assembly->order_id;
            }
        }
        return $orders;
    }

    public function getHasSnProductsAttribute()
    {
        return $this->assemblies()->whereIn('assemblies.product_id', Product::SNids())->exists();
    }

    public function getSnHasBeenSetAttribute()
    {
        if($this->has_sn_products)
        {
            if($this->serials()->exists())
            {
                return true;
            }
            return false;
        }
        return false;
    }


    public function getPurchaseMaxConsegnaAttribute()
    {
        $ids = $this->purchases()->pluck('product_id')->toArray();
        return Product::whereIn('id', $ids)->max('tempo_fornitura');
    }

    public function getPurchaseTotalAttribute()
    {
        $total = 0;
        foreach ($this->purchases as $item)
        {
            $total += $item->qta * $item->product->prezzo_acquisto;
        }
        return $total;
    }

    public function getStatoAttribute()
    {
        if($this->purchase)
        {
            $qpu = $this->purchases();
            return round(((clone $qpu)->sum('qta_arrived') / $qpu->sum('qta')) * 100);
        }

        if($this->production)
        {
            $qpr = $this->productions();
            return round(((clone $qpr)->sum('input_qta_sent') / $qpr->sum('input_qta')) * 100);
        }

        if($this->assembly)
        {
            $qa = $this->assemblies();
            return round(((clone $qa)->sum('qta_ready') /  $qa->sum('qta')) * 100);
        }


        return 0;
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

    public function getPurchaseAttribute()
    {
        if($this->type == 'Purchase')
        {
            return 1;
        }
        return 0;
    }

    public function getProductionAttribute()
    {
        if($this->type == 'Production')
        {
            return 1;
        }
        return 0;
    }

    public function getAssemblyAttribute()
    {
        if($this->type == 'Assembly')
        {
            return 1;
        }
        return 0;
    }

    public function getShippingAttribute()
    {
        if($this->type == 'Shipping')
        {
            return 1;
        }
        return 0;
    }



    public function getNameAttribute()
    {
        return 'Ord. '.$this->type. ' '.$this->id;
    }

//CHECKS



}
