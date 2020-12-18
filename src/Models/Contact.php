<?php

namespace Jacofda\Klaxon\Models;

use Carbon\Carbon;

class Contact extends Primitive
{

//ELOQUENT
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function lists()
    {
        return $this->belongsToMany(NewsletterList::class, 'contact_list', 'contact_id', 'list_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_contact');
    }

    public function clients()
    {
        return $this->morphToMany(Client::class, 'clientable');
    }

// GETTERS AND SETTERs
    public function getFullnameAttribute()
    {
        return $this->nome . ' ' . $this->cognome;
    }

    public function getRagSocAttribute()
    {
        if($this->company_id)
        {
            return $this->company->rag_soc;
        }
        return null;
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = ucwords(strtolower($value));
    }

    public function setCognomeAttribute($value)
    {
        $this->attributes['cognome'] = ucwords(strtolower($value));
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }


//SCOPES & FILTERS
    public function scopeUser($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function scopeSubscribed($query)
    {
        return $query->where('subscribed', 1);
    }

    public function scopeIscritti($query, $value)
    {
        return $query->where('subscribed', $value);
    }

    public function scopeOrigine($query, $value)
    {
        return $query->where('origin', $value);
    }

    public function isOfType($type_id)
    {
        if(is_array($type_id))
        {
            return $this->clients()->whereIn('id',$type_id)->exists();
        }

        return $this->clients()->where('id',$type_id)->exists();
    }

    public function isNotOfType($type_id)
    {
        if(is_array($type_id))
        {
            return !$this->clients()->whereIn('id',$type_id)->exists();
        }

        return !$this->clients()->where('id',$type_id)->exists();
    }


    public function scopeBelongToList($query, $list_id)
    {
        $contactIds = NewsletterList::find($list_id)->contacts()->pluck('contact_id')->toArray();
        return $query = $query->whereIn('id', $contactIds );
    }

    public function getAvatarAttribute()
    {
        $arr = explode(' ', $this->fullname);
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


    public function getNewsletterInviateAttribute()
    {
        if($this->reports()->exists())
        {
            return $this->reports()->inviate()->count();
        }
        return 0;
    }

    public function getNewsletterAperteAttribute()
    {
        if($this->reports()->exists())
        {
            return $this->reports()->aperte()->count();
        }
        return 0;
    }

    public function getNewsletterClickedAttribute()
    {
        if($this->reports()->exists())
        {
            return $this->reports()->clicked()->count();
        }
        return 0;
    }


    public function getNewsletterStatsAttribute()
    {
        return [
            'inviate' => $this->newsletter_inviate,
            'aperte' => $this->newsletter_aperte,
            'clicks' => $this->newsletter_clicked
        ];
    }


    public static function uniquePos()
    {
        return Contact::whereNotNull('pos')->distinct()->pluck('pos', 'pos')->toArray();
    }

    public static function uniqueOrigin()
    {
        return Contact::whereNotNull('pos')->distinct()->pluck('origin', 'origin')->toArray();
    }


    public static function filter($data)
    {

        if($data->get('tipo'))
        {
            if(strpos($data['tipo'], '|'))
            {
                $types = explode('|', $data['tipo']);
                $query = self::whereHas('clients', function($query) use($types) {
                                $query->whereIn('id', $types);
                            })->with('clients', 'city');
            }
            else
            {
                $query = Client::find($data['tipo'])->contacts()->with('city', 'clients');
            }
        }
        else
        {
            $query = self::with('city', 'clients');
        }

        if($data->get('sector'))
        {
            $sector = $data->get('sector');
            $query->whereHas('company', function($query) use($sector) {
                            $query->where('sector_id', $sector);
                        });
        }

        if($data->get('search'))
        {
            $like = '%'.$data['search'].'%';
            $query = $query->where('nome', 'like', $like )
                            ->orWhere('cognome', 'like', $like )
                            ->orWhere('email', 'like', $like )
                            ->orWhere('citta', 'like', $like );
        }

        if($data->get('region'))
        {
            if($data->get('region') != '')
            {
                if(strpos($data['region'], '|'))
                {
                    $regions = explode('|', $data['region']);
                    $query = $query->region( $regions );
                }
                else
                {
                    $query = $query->region( $data['region'] );
                }
            }
        }

        if($data->get('province'))
        {
            if($data->get('province') != '')
            {
                if(strpos($data['province'], '|'))
                {
                    $provinces = explode('|', $data['province']);
                    $query = $query->province( $provinces );
                }
                else
                {
                    $query = $query->province( $data['province'] );
                }
            }
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

        if($data->get('origin'))
        {
            if($data->get('origin') != '')
            {
                $query = $query->origine($data->get('origin'));
            }
        }

        if($data->get('subscribed'))
        {
            if($data->get('subscribed') != '')
            {
                $query = $query->iscritti(intval($data->get('subscribed')));
            }
        }

        if($data->get('range'))
        {
            $range = explode(' - ', $data->range);
            $da = Carbon::createFromFormat('d/m/Y', $range[0])->format('Y-m-d');
            $a =  Carbon::createFromFormat('d/m/Y', $range[1])->format('Y-m-d');
            $query = $query->whereBetween('created_at', [$da, $a]);
        }

        if($data->get('list'))
        {
            if($data->get('list') != '')
            {
                $query = $query->belongToList( $data['list'] );
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



    public static function createOrUpdate($contact, $data, $user_id = null)
    {
        if(is_null($user_id))
        {
            $user_id = $data['user_id'];
        }

        $nazione = strtoupper($data['nazione']);
        $provincia = $data['provincia'];
        if(isset($data['provincia']))
        {
            if(strlen($data['provincia']) == 2)
            {
                $provincia = City::provinciaFromSigla( strtoupper($data['provincia']) );
            }
        }
        if(isset($data['pos']))
        {
            $contact->pos = $data['pos'];
        }

        $contact->nome = $data['nome'];
        $contact->cognome = $data['cognome'];
        $contact->cellulare = $data['cellulare'];
        $contact->nazione = $data['nazione'];
        $contact->email = $data['email'];
        $contact->indirizzo = $data['indirizzo'];
        $contact->cap = $data['cap'];
        $contact->citta = $data['citta'];
        $contact->provincia = $provincia;
        $contact->city_id = City::getCityIdFromData($provincia, $nazione, $data['citta']);
        $contact->nazione = $nazione;
        if($data['nazione'] != 'IT' )
        {
            $contact->lingua = 'en';
        }
        $contact->user_id = $user_id;
        $contact->company_id = $data['company_id'];
        $contact->origin = $data['origin'];
        $contact->save();

        if(isset($data['clients']))
        {
            if(!empty($data['clients']))
            {
                $contact->clients()->sync($data['clients']);
            }
        }

        if(isset($data['tipo']))
        {
            if(!empty($data['tipo']))
            {
                $tipo = ucfirst(strtolower($data['tipo']));
                $client = Client::where('nome', $tipo)->first();
                if(!is_null($client))
                {
                    $contact->clients()->sync($client->id);
                }
            }
        }

        return $contact;
    }








}
