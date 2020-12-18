<?php

namespace Jacofda\Klaxon\Models;

use Jacofda\Klaxon\Models\Crm\{Supplier, Pricelist};
use Jacofda\Klaxon\Models\Erp\{Check, Magazzini};
use Jacofda\Klaxon\Models\Setting;

class Company extends Primitive
{
    protected $casts = [
        'note' => 'array'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_company');
    }

    public function clients()
    {
        return $this->morphToMany(Client::class, 'clientable');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pricelist()
    {
        return $this->belongsTo(Pricelist::class);
    }

    public function checks()
    {
        return $this->morphMany(Check::class, 'checkable');
    }

// RECURSIVE
    public function children()
    {
        return $this->hasMany(Company::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_id', 'id');
    }

    public function getMotherAttribute()
    {
        if ($this->parent_id)
        {
            return $this->parent->mother;
        }
        return $this;
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function allChildrenIds()
    {
        $children_companies = collect();
        foreach ($this->children as $child_company)
        {
            $children_companies->push($child_company->id);
            $children_companies = $children_companies->merge($child_company->allChildrenIds());
        }

        return $children_companies->toArray();
    }

    public function allChildrenStudentIds()
    {
        $arr = [];
        $companiesIds = $this->allChildrenIds();
        $companies = self::whereIn('id', $companiesIds)->get();
        foreach($companies as $company)
        {
            $contacts = $company->contacts()->whereHas('clients', function($query){
                $query->where('id', Client::Student()->id);
            })->pluck('id')->toArray();

            $arr = array_merge($arr, $contacts);
        }

        return $arr;
    }

    public function getCountChildrenAttribute()
    {
        $count = 0;
        foreach($this->children as $c1)
        {
            $count++;
            if($c1->children()->exists())
            {
                foreach($c1->children as $c2)
                {
                    $count++;
                    if($c2->children()->exists())
                    {
                        foreach($c2->children as $c3)
                        {
                            $count++;
                        }
                    }
                }
            }
        }
        return $count;
    }


    public function setNazioneAttribute($value)
    {
        $this->attributes['nazione'] = $value;
        if($value == 'IT')
        {
            $this->attributes['lingua'] = strtolower($value);
        }
        else
        {
            $this->attributes['lingua'] = 'en';
        }
    }

    public function setIndirizzoAttribute($value)
    {
        $this->attributes['indirizzo'] = ucfirst($value);
    }


    public function getAvatarAttribute()
    {
        $arr = explode(' ', $this->rag_soc);
        $letters = '';$count = 0;
        foreach($arr as $value)
        {
            if($count < 2)
            {
                $letters .= trim(strtoupper(substr($value, 0, 1)));
            }
            $count++;
        }
        if( strlen($letters) == 1)
        {
            $letters = trim(strtoupper(substr($arr[0], 0, 2)));
        }

        return '<div class="avatar">'.$letters.'</div>';
    }


    public function getCfAttribute()
    {
        if(!$this->privato)
        {
            return $this->piva;
        }
        return $this->attributes['cf'];
    }

    public function getIsItalianAttribute()
    {
        if($this->nazione == 'IT')
        {
            return true;
        }
        return false;
    }

    public function getInvoiceEmailAttribute()
    {
        if($this->email_fatture)
        {
            return $this->email_fatture;
        }
        return $this->email;
    }

    public function getIsHomeAttribute()
    {
        if($this->rag_soc == Setting::base()->rag_soc)
        {
            return true;
        }
        return false;
    }

// SCOPES
    public function scopeSupplier($query)
    {
        $query = $query->where('fornitore', true);
    }

    public function scopeSettore($query, $value)
    {
        $query = $query->where('sector_id', $value);
    }

    public function scopeNotproduction($query)
    {
        $query = $query->whereNotIn('id', Magazzini::Production());
    }


    public static function uniqueCountries()
    {
        return self::select('nazione')->distinct()->get();
    }

//FILTERS
    public static function filter($data)
    {

        if($data->has('tipo') && $data->get('tipo'))
        {
            $query = Client::find($data->get('tipo'))->companies()->with('clients');
        }
        else
        {
            $query = self::with('clients');
        }

        if(request()->has('sector') && request()->get('sector'))
        {
            $query = $query->settore(request('sector'));
        }


        if($data->get('created_at'))
        {
            if($data->get('created_at') != '')
            {
                $query = $query->created( $data['created_at'] );
            }
        }

        if($data->get('updated_at'))
        {
            if($data->get('updated_at') != '')
            {
                $query = $query->updated( $data['updated_at'] );
            }
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

}
