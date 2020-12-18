<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Client, Company, Country, Sector};
use Jacofda\Klaxon\Models\Crm\{Supplier, Pricelist};

class CompanyController extends Controller
{
    public function index()
    {
        if(request()->input())
        {
            $companies = Company::filter(request())->paginate(30);
        }
        else
        {
            $companies = Company::notproduction()->with('clients')->paginate(30);
        }
// whereNotIn('id', [])->
        return view('jacofda::core.companies.index', compact('companies'));
    }


    public function create()
    {
        $countries = Country::listCountries();
        $clients = Client::company()->pluck('nome', 'id')->toArray();
        $clientsSelected = [];
        $referenti = [''=>''];
        if(Client::Referente())
        {
            $referenti += Client::Referente()->companies()->pluck('rag_soc', 'id')->toArray();
        }
        $sectors = [''=>'']+Sector::pluck('nome', 'id')->toArray();
        $suppliers = [''=>'']+Supplier::pluck('nome', 'id')->toArray();
        $pricelists = [''=>''];
        return view('jacofda::core.companies.create', compact('countries', 'clients', 'clientsSelected', 'referenti', 'sectors', 'suppliers', 'pricelists'));
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
            'rag_soc' => "required|unique:companies,rag_soc",
            'email' => "required|email|unique:companies,email",
        ]);


        $sector_id = null;
        if(!is_null($request->sector_id))
        {
            if(is_numeric($request->sector_id))
            {
                $sector_id = $request->sector_id;
            }
            else
            {
                $sector_id = Sector::create(['nome' => $request->sector_id])->id;
            }
        }

        $company = new Company;
            $company->rag_soc = $request->rag_soc;
            $company->nazione = $request->nazione;
            $company->lingua = $request->lingua;
            $company->valuta = $request->valuta;
            $company->indirizzo = $request->indirizzo;
            $company->citta = $request->citta;
            $company->cap = $request->cap;
            $company->provincia = $request->provincia;
            $company->email = $request->email;
            $company->email_ordini = $request->email_ordini;
            $company->email_fatture = $request->email_fatture;
            $company->telefono = $request->telefono;
            $company->pec = $request->pec;
            $company->piva = $request->piva;
            $company->cf = $request->cf;
            $company->fornitore = $request->fornitore;
            $company->partner = $request->partner;
            $company->attivo = $request->attivo;
            $company->parent_id = $request->parent_id;
            $company->sector_id = $sector_id;
            $company->pricelist_id = $request->pricelist_id;
            $company->supplier_id = $request->supplier_id;
            $company->note = $request->note;
            $company->numero = $request->numero;
        $company->save();


        if(!empty($request->clients))
        {
            $company->clients()->attach($request->clients);
        }

        return redirect(route('companies.index'))->with('message', 'Azienda Creata');
    }


    public function show(Company $company)
    {
        return view('jacofda::core.companies.show', compact('company'));
    }


    public function edit(Company $company)
    {
        $countries = Country::listCountries();
        $clients = Client::company()->pluck('nome', 'id')->toArray();
        $clientsSelected = $company->clients()->pluck('id')->toArray();
        $referenti = [''=>''];
        if(Client::Referente())
        {
            $referenti += Client::Referente()->companies()->pluck('rag_soc', 'id')->toArray();
        }
        $sectors = [''=>'']+Sector::pluck('nome', 'id')->toArray();
        $suppliers = [''=>'']+Supplier::pluck('nome', 'id')->toArray();
        $pricelists = [''=>''];
        return view('jacofda::core.companies.edit', compact('countries', 'company', 'clients', 'clientsSelected', 'referenti', 'sectors', 'suppliers', 'pricelists'));
    }


    public function update(Request $request, Company $company)
    {

        $this->validate(request(),[
            'rag_soc' => "required|unique:companies,rag_soc,".$company->id.",id",
            'piva' => "required_if:privato,0",
            'pec' => "nullable|unique:companies,pec,".$company->id.",id",
            'cap' => "numeric",
        ]);


        $lingua = 'it';
        if($request->nazione != 'IT')
        {
            $lingua = 'en';
        }

        $sector_id = null;
        if(!is_null($request->sector_id))
        {
            if(is_numeric($request->sector_id))
            {
                $sector_id = $request->sector_id;
            }
            else
            {
                $sector_id = Sector::create(['nome' => $request->sector_id])->id;
            }
        }

            $company->rag_soc = $request->rag_soc;
            $company->nazione = $request->nazione;
            $company->lingua = $request->lingua;
            $company->valuta = $request->valuta;
            $company->indirizzo = $request->indirizzo;
            $company->citta = $request->citta;
            $company->cap = $request->cap;
            $company->provincia = $request->provincia;
            $company->email = $request->email;
            $company->email_ordini = $request->email_ordini;
            $company->email_fatture = $request->email_fatture;
            $company->telefono = $request->telefono;
            $company->pec = $request->pec;
            $company->piva = $request->piva;
            $company->cf = $request->cf;
            $company->fornitore = $request->fornitore;
            $company->partner = $request->partner;
            $company->attivo = $request->attivo;
            $company->parent_id = $request->parent_id;
            $company->sector_id = $sector_id;
            $company->pricelist_id = $request->pricelist_id;
            $company->supplier_id = $request->supplier_id;
            $company->note = $request->note;
            $company->numero = $request->numero;
        $company->save();


        if(!empty($request->clients))
        {
            $company->clients()->sync($request->clients);
        }
        return redirect(route('companies.index'))->with('message', 'Azienda Aggiornata');
    }


    public function destroy(Company $company)
    {
        $company->clients()->detach();
        $company->delete();
        return 'done';
    }

//api/companies/{id} - GET
    public function checkNation(Company $company)
    {
        return $company->nazione;
    }

//api/ta/companies/{$q} - GET
    public function tasearch($q)
    {
        return Company::select('rag_soc as name')->where('rag_soc', 'like', '%'.$q.'%')->get();
    }

//api/ta/companies/ - GET
    public function taindex()
    {
        return Company::select('rag_soc as name', 'id')->get();
    }

    public function getNote(Company $company)
    {
        return $company->note;
    }

    public function addNote(Request $request, Company $company)
    {

        $company->note = $request->obj;
        $company->save();

        return 'done';
    }


}
