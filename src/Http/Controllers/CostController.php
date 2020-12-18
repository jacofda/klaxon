<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Category, Company, Cost, Expense, Stat};
use App\User;
//use App\Classes\Fe\Actions\UploadIn;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Cost::filter(request());

        $totale = Stat::TotaleQueryCosti($query);
        $imposte = Stat::ImposteQueryCosti($query);
        $categories = Stat::CategoriaQueryCosti($query);

        $costs = $query->paginate(50);

        $companies = [''=>'']+Company::supplier()->orderBy('rag_soc', 'ASC')->pluck('rag_soc', 'id')->toArray();
        $selectCats = [''=>'']+Category::categoryOf('Expense')->pluck('nome', 'id')->toArray();

        return view('jacofda::core.accounting.costs.index', compact('costs', 'totale', 'imposte', 'categories', 'companies', 'selectCats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = [''=>'']+Company::supplier()->pluck('rag_soc', 'id')->toArray();
        $expenses = [''=>'']+Expense::pluck('nome', 'id')->toArray();
        $selectedCompany = '';
        $selectedExpense = '';
        return view('jacofda::core.accounting.costs.create', compact('companies', 'expenses', 'selectedCompany', 'selectedExpense'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'numero' => 'nullable|unique:costs',
            'company_id' => 'required',
            'expense_id' => 'required',
            'data' => 'required',
            'imponibile' => 'required|numeric',
            'totale' => 'required|numeric',
        ]);

        Cost::create($request->except('_token', 'anno'));

        return redirect(route('costs.index'))->with('message', 'Acquisto Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show(Cost $cost)
    {
        dd($cost);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function edit(Cost $cost)
    {
        $companies = []+Company::supplier()->pluck('rag_soc', 'id')->toArray();
        $expenses = []+Expense::pluck('nome', 'id')->toArray();
        $selectedCompany = $cost->company_id;
        $selectedExpense = $cost->expense_id;

        return view('jacofda::core.accounting.costs.edit', compact('cost', 'companies', 'expenses', 'selectedCompany', 'selectedExpense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cost $cost)
    {

        $this->validate(request(),[
            'company_id' => 'required',
            'expense_id' => 'required',
            'data' => 'required',
            'imponibile' => 'required|numeric',
            'totale' => 'required|numeric',
        ]);

        $cost->update($request->except('_token', 'anno'));

        return redirect(route('costs.index'))->with('message', 'Acquisto Aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cost $cost)
    {
        return 'done';
    }

//api/invoices/saldato - POST
    public function toggleSaldato(Request $request)
    {
        $cost = Cost::find($request->id);
            $cost->saldato = intval($request->saldato);
        $cost->save();

        if(intval($request->saldato) === 1)
        {
            return "Ora il costo risulta pagato";
        }
        return 'Costo non saldato';
    }

//api/ta/costs/ - GET
    public function taindex()
    {
        return Cost::select('numero as name', 'id')->get();
    }


//api/costs/import - GET
    public function import()
    {
        return view('jacofda::core.accounting.costs.import');
    }

//api/costs/import - POST
    public function importProcess(Request $request)
    {
        if(config('core.modules')['fe'])
        {
            $class = new UploadIn($request->file);
            try
            {
                $class->init();
            }
            catch(\Exception $e)
            {
                return back()->with('error', 'Fattura non caricata');
            }
        }
        return back()->with('message', 'Fattura Aggiunta');
    }

//api/costs/export?anno=2020&company=&mese=02&range=&saldato=&tipo= - GET
    public function exportXmlInZip()
    {
        if(request()->input())
        {
            $costs = Cost::filter(request())->get();
        }
        else
        {
            $costs = Cost::anno(date('Y'))->get();
        }

        foreach($costs as $cost)
        {
            if(!$cost->media()->exists()){
                dd($cost);
            }
        }

        $zip_file = 'costs.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach($costs as $cost)
        {
            if($cost->real_xml)
            {
                $zip->addFile($cost->real_xml, $cost->media()->xml()->first()->filename);
            }
        }
        $zip->close();

        return response()->download($zip_file);
    }

}
