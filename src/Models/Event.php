<?php

namespace Jacofda\Klaxon\Models;

use \Carbon\Carbon;
use App\User;

class Event extends Primitive
{
    protected $casts = [
        'starts_at' => 'datetime:Y-m-d H:i:s',
        'ends_at' => 'datetime:Y-m-d H:i:s',
    ];

    //il creatore dell'evento (proprietario del calendario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //il calendario associato all'evento
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }

    //altri utenti associati all'evento
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    //contatti associati all'evento
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'event_contact', 'event_id', 'contact_id');
    }

    //aziende associati all'evento
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'event_company', 'event_id', 'company_id');
    }

    public function scopeBetweenDates($query, $dates)
    {
        $start = Carbon::parse($dates['start'])->format('Y-m-d H:i:s');
        $end = Carbon::parse($dates['end'])->format('Y-m-d H:i:s');
        return $query = $query->whereDate('starts_at', '>=', $start)->whereDate('ends_at', '<=', $end);
    }

    /*
     * swap default color to new (max 3 extra calendars)
     * @param  [collection] $events [with original colors]
     * @param  [int] $key    [loop key]
     * @return [collection] [with new colors]
     */
    public static function mutateColors($events, $key)
    {
        $newColor = [
            0 => '#3788d8',
            1 => '#ff1a1a',
            2 => '#009933',
            3 => '#ffa31a'
        ];

        $events = $events->map(function ($event) use($key, $newColor) {
            $event->backgroundColor = $newColor[$key];
            $event->borderColor = $newColor[$key];
            return $event;
        });

        return $events;
    }

    /*
     * attach many to many relation
     * @param  [model] $event
     * @param  [request] $request
     * @return void
     */
    public static function attachModels($event, $request)
    {
        if($request->contact_id)
        {
            $event->contacts()->attach($request->contact_id);
        }
        if($request->user_id)
        {
            $event->users()->attach($request->user_id);
        }
        if($request->company_id)
        {
            $event->companies()->attach($request->company_id);
        }
    }

}
