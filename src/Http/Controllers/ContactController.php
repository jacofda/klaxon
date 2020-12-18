<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Jacofda\Klaxon\Models\{City, Contact, Country, Client, Company, NewsletterList, Role};
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->input())
        {
            if(request('id'))
            {
                $query = Contact::where('id', request('id'));
            }
            else
            {
                $query = Contact::filter(request());
            }

        }
        else
        {
            $query = Contact::query();
        }

        $contacts = $query->paginate(100);

        return view('jacofda::core.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = City::uniqueProvinces();
        $countries = Country::listCountries();
        $companies[''] = '';
        $companies += Company::pluck('rag_soc', 'id')->toArray();
        $users[''] = '';
        $users += User::with('contact')->get()->pluck('contact.fullname', 'id')->toArray();
        $lists = NewsletterList::pluck('nome', 'id')->toArray();
        $clients = Client::contact()->pluck('nome', 'id')->toArray();
        $clientsSelected = [];
        $pos = ['' => '']+Contact::uniquePos();
        $origins = ['' => '']+Contact::uniqueOrigin();
        return view('jacofda::core.contacts.create', compact('provinces', 'countries', 'companies', 'users', 'lists', 'clients', 'clientsSelected', 'pos', 'origins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required|email|unique:contacts'
        ]);
        Contact::createOrUpdate(new Contact, request()->input());
        return redirect(route('contacts.index'))->with('message', 'Contatto Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contacts\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('jacofda::core.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contacts\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $provinces = City::uniqueProvinces();
        $countries = Country::listCountries();
        $companies[''] = '';
        $companies += Company::pluck('rag_soc', 'id')->toArray();
        $users[''] = '';
        $users += User::with('contact')->get()->pluck('contact.fullname', 'id')->toArray();
        $lists = NewsletterList::pluck('nome', 'id')->toArray();

        $clients = Client::contact()->pluck('nome', 'id')->toArray();
        $clientsSelected = $contact->clients()->pluck('id')->toArray();
        $pos = ['' => '']+Contact::uniquePos();
        $origins = ['' => '']+Contact::uniqueOrigin();
        return view('jacofda::core.contacts.edit', compact('provinces', 'countries', 'companies', 'users', 'contact', 'lists', 'clients', 'clientsSelected', 'pos', 'origins'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contacts\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {

        $this->validate(request(), [
            'nome' => 'required',
            'cognome' => 'required',
            'email' => "required|email|unique:contacts,email,".$contact->id.",id"
        ]);
        Contact::createOrUpdate($contact, request()->input());
        return redirect(route('contacts.index'))->with('message', 'Contatto Aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contacts\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->clients()->detach();
        $contact->delete();
        return 'done';
    }

//contacts-validate-file
    public function validateFile(Request $request)
    {
        $this->validate(request(), [
            'file' => 'mimes:csv'
        ]);
    }

//contacts/-comapny
    public function Company(Request $request)
    {
        $prospect = Client::Prospect();
        $contact = Contact::find($request->id);

        $company = new Company;
            $company->rag_soc = $contact->fullname;
            $company->indirizzo = $contact->indirizzo;
            $company->cap = $contact->cap;
            $company->citta = $contact->citta;
            $company->provincia = $contact->provincia;
            $company->city_id = $contact->city_id;
            $company->nazione = $contact->nazione;
            $company->lingua = $contact->lingua;
            $company->email = $contact->email;
        $company->save();

        $contact->company_id = $company->id;
        $contact->save();
        $contact->clients()->sync([$prospect->id]);

        $company->clients()->save($prospect);

        return redirect( route('contacts.edit', $contact->id ) )->with('message', 'Azienda da contatto creata! Assicurati di compilare i campi mancanti');
    }


//contacts/make-user
    public function makeUser(Request $request)
    {
        $contact = Contact::find($request->id);
        if(is_null($contact->email))
        {
            return redirect(route('contacts.index'))->with('error', "Questo contatto non ha un'email. Impossibile creare l'utente");
        }

        $rs = str_random(8);

        $user = User::create([
            'email' => $contact->email,
            'password' => bcrypt($rs)
        ]);

        $contact->user_id = $user->id;
        $contact->save();

        return redirect(route('contacts.index'))->with('message', "Utente creato ". $rs .". Potrà chiedere una nuova password usando l'email: ".$contact->email);
    }


//api/ta/contacts
    public function taindex()
    {
        $contacts = [];$count = 0;

        foreach(Contact::all('nome', 'cognome', 'id') as $contact)
        {
            $contacts[$count]['id'] = $contact->id;
            $contacts[$count]['name'] = $contact->nome . ' ' . $contact->cognome;
            $count++;
        }

        return $contacts;

    }

}
