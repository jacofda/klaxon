<?php

namespace Jacofda\Klaxon\Http\Controllers;

use App\User;
use Jacofda\Klaxon\Models\{Calendar, Contact, Company, Event};
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{

//api/events/
    public function defaultUserEvent()
    {
        return auth()->user()->default_calendar->events()
                ->betweenDates($request->input())
                ->select('id', 'title', 'starts_at as start', 'ends_at as end' ,'allday', 'backgroundColor', 'backgroundColor as borderColor')
                ->get();
    }

//api/events/{userId}
    public function userEvent($id, Request $request)
    {
        return User::find($id)->default_calendar->events()
                ->betweenDates($request->input())
                ->select('id', 'title', 'starts_at as start', 'ends_at as end' ,'allday', 'backgroundColor', 'backgroundColor as borderColor')
                ->get();
    }

//api/events/{event}/done
    public function markAsDone(Event $event)
    {
        $event->update(['done' => 1, 'backgroundColor' => '#36e25d']);
        return 'done';
    }


//api/calendars/{calendar_id}/events
    public function calendarEvent($id, Request $request)
    {
        if(is_numeric($id))
        {
            return Calendar::find($id)->events()
                    ->betweenDates($request->input())
                    ->select('id', 'title', 'starts_at as start', 'ends_at as end' ,'allday', 'backgroundColor', 'backgroundColor as borderColor')
                    ->get();
        }

        $arrIds = explode('-', $id);
        $collection = collect();

        foreach ($arrIds as $key => $id_calendar)
        {
            $events = Calendar::find($id_calendar)->events()
                    ->betweenDates($request->input())
                    ->select('id', 'calendar_id' ,'title', 'starts_at as start', 'ends_at as end' , 'allday', 'backgroundColor', 'backgroundColor as borderColor')
                    ->get();

            Event::mutateColors($events, $key);

            $collection = $collection->merge($events);
        }

        return $collection->all();
    }

//events - POST
    public function store(Request $request)
    {

        if($request->type == 'ricursivo')
        {
            $idsRecursive = [];
            for($x=0; $x < $request->x_times; $x++)
            {
                $starts_at = Carbon::createFromFormat('d/m/Y H:i', $request->from_date . ' ' . ($request->da_ora) .':'.$request->da_minuto);
                $ends_at = Carbon::createFromFormat('d/m/Y H:i', $request->from_date . ' ' . ($request->a_ora) .':'.$request->a_minuto);

                if(strpos($request->every, 'd') !== false)
                {
                    $days = intval($request->every);
                    $start = $starts_at->addDays($x*$days)->format('Y-m-d H:i:s');
                    $end = $ends_at->addDays($x*$days)->format('Y-m-d H:i:s');
                }
                else
                {
                    $start = $starts_at->addMonths($x*$request->every)->format('Y-m-d H:i:s');
                    $end = $ends_at->addMonths($x*$request->every)->format('Y-m-d H:i:s');
                }

                $data = [
                    'starts_at' => $start,
                    'ends_at' => $end,
                    'summary' => $request->summary,
                    'title' => $request->titolo,
                    'location' => $request->location,
                    'user_id' => auth()->user()->id,
                    'calendar_id' => $request->calendar_id,
                    'backgroundColor' => '#ffc107'
                ];

                $event = Event::create($data);

                Event::attachModels($event, $request);

                $idsRecursive[] = $event->id;
            }

            return Event::whereIn('id', $idsRecursive)->get();

        }
        elseif($request->type == 'singolo')
        {
            $event = Event::create([
                'starts_at' => Carbon::createFromFormat('d/m/Y H:i', $request->date_singolo . ' ' . ($request->da_ora) .':'.$request->da_minuto)->format('Y-m-d H:i:s'),
                'ends_at' => Carbon::createFromFormat('d/m/Y H:i', $request->date_singolo . ' ' . ($request->a_ora) .':'.$request->a_minuto)->format('Y-m-d H:i:s'),
                'summary' => $request->summary,
                'title' => $request->titolo,
                'location' => $request->location,
                'user_id' => auth()->user()->id,
                'calendar_id' => $request->calendar_id
            ]);
        }
        elseif($request->type == 'allday')
        {
            $arr = explode(' - ', $request->range);
            $event = Event::create([
                'starts_at' => Carbon::createFromFormat('d/m/Y H:i:s', trim($arr[0]).' 08:00:00')->format('Y-m-d H:i:s'),
                'ends_at' => Carbon::createFromFormat('d/m/Y H:i:s', trim($arr[1]).' 23:59:59')->format('Y-m-d H:i:s'),
                'summary' => $request->summary,
                'title' => $request->titolo,
                'location' => $request->location,
                'allday' => true,
                'backgroundColor' => '#28a745',
                'user_id' => auth()->user()->id,
                'calendar_id' => $request->calendar_id
            ]);
        }

        Event::attachModels($event, $request);

        //todo duplicate event if has an other user
        // if(count($request->user_id))
        // {
        //
        // }

        return $event;
    }

//events/{id} - GET
    public function show(Event $event)
    {
        return $event->where('id', $event->id)->with('companies', 'users', 'contacts')->get();
    }

//events/{id}/edit - GET
    public function edit(Event $event)
    {
        $contacts= Contact::all()->pluck('fullname' ,'id')->toArray();
        $companies = Company::pluck('rag_soc', 'id')->toArray();
        $users = User::with('contact')->get()->pluck('contact.fullname', 'id')->toArray();


            $selectedCompany = $event->companies()->pluck('id');
            $selectedUsers = $event->users()->pluck('id');
            $selectedContacts = $event->contacts()->pluck('id');

        return view('jacofda::core.events.edit', compact('event', 'contacts', 'selectedContacts', 'companies', 'selectedCompany', 'users', 'selectedUsers'));
    }

//events/{id}/edit - GET
    public function update(Event $event, Request $request)
    {
        if($request->range)
        {

        }
        else
        {
            $event->starts_at = Carbon::createFromFormat('d/m/Y H:i', $request->from_date . ' ' . ($request->da_ora) .':'.$request->da_minuto)->format('Y-m-d H:i:s');
            $event->ends_at = Carbon::createFromFormat('d/m/Y H:i', $request->from_date . ' ' . ($request->a_ora) .':'.$request->a_minuto)->format('Y-m-d H:i:s');
            $event->title = $request->title;
            $event->summary = $request->summary;
        }

        $event->save();

        if($request->contact_id)
        {
            $event->contacts()->sync($request->contact_id);
        }
        if($request->user_id)
        {
            $event->users()->sync($request->user_id);
        }
        if($request->company_id)
        {
            $event->companies()->sync($request->company_id);
        }

        return redirect('calendars/'.$event->calendar_id)->with('message', 'Evento modificato');
    }

//events/{id} - DELETE
    public function destroy(Event $event, Request $request)
    {
        $calendar_id = $event->calendar_id;
        $event->delete();
        return redirect('calendars/'.$calendar_id)->with('message', 'Evento eliminato');
    }


}
