<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
use Jacofda\Klaxon\Models\{Calendar, Client, Contact, Company, Event, Report};


class PagesController extends Controller
{

    public function home()
    {
        $aziendeLables = '';$aziendeData = '';
        foreach(Client::company()->get() as $type)
        {
            $aziendeLables .= '"'.$type->nome.'",';
            $aziendeData .= $type->companies()->count().',';
        }
        $aziende = (object) [
            'labels' => substr($aziendeLables, 0, -1),
            'data' => substr($aziendeData, 0, -1),
            'total' => Company::count()
        ];

        $contattiLables = '';$contattiData = '';
        foreach(Client::contact()->get() as $type)
        {
            $contattiLables .= '"'.$type->nome.'",';
            $contattiData .= $type->contacts()->count().',';
        }
        $contatti = (object) [
            'labels' => substr($contattiLables, 0, -1),
            'data' => substr($contattiData, 0, -1),
            'total' => Contact::count()
        ];

        return view('jacofda::welcome', compact('aziende', 'contatti'));
    }


    public function showCalendar()
    {
        $contacts= Contact::all()->pluck('fullname' ,'id')->toArray();
        $companies[''] = '';
        $companies += Company::pluck('rag_soc', 'id')->toArray();
        $users = User::with('contact')->get()->pluck('contact.fullname', 'id')->toArray();
        $userEvents = Event::where('user_id', auth()->user()->id)->select('title', 'starts_at as start', 'ends_at as end' ,'allday', 'backgroundColor', 'backgroundColor as borderColor')->get();

        return view('jacofda::core.calendars.show', compact('users', 'companies', 'contacts', 'userEvents'));
    }


}
