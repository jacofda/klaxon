<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Company, Product};
use Jacofda\Klaxon\Models\Erp\{Check, Work};
use \DB;
use Carbon\Carbon;

class WorkController extends Controller
{
    public function index()
    {
        $query = Work::query();
        $works = $query->paginate(50);

        return view('jacofda::core.erp.works.index', compact('works'));
    }


    public function create()
    {
        $products = [''=>'']+Product::select(\DB::raw('CONCAT(codice," - ",nome_it) AS text'), 'id')->pluck('text', 'id')->toArray();
        $suppliers = [''=>'']+Company::where('fornitore', 1)->pluck('rag_soc', 'id')->toArray();
        $select = Product::orderBy('codice', 'ASC')->select(\DB::raw('CONCAT(codice," - ",nome_it) AS text'), 'id')->get();

        $tp = Product::all();

        return view('jacofda::core.erp.works.create', compact('products', 'suppliers', 'select', 'tp'));
    }

    public function show(Work $work)
    {
        return view('jacofda::core.erp.works.show', compact('work'));
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'nome_it' => 'required',
            'codice' => 'required',
            'company_id' => 'required',
            'product_id' => 'required',
            'input.id.*' => 'required',
            'input.qta.*' => 'required'
        ]);


        $work = new Work;
            $work->nome_it = $request->nome_it;
            $work->nome_en = $request->nome_en;
            $work->nome_de = $request->nome_de;
            $work->descrizione = $request->descrizione;
            $work->versione = $request->versione;
            $work->codice = $request->codice;
            $work->company_id = $request->company_id;
            $work->product_id = $request->product_id;
            $work->cost = $request->cost;
            $work->time = $request->time;
        $work->save();

        $inputs = [];
        foreach($request->input['id'] as $key => $input)
        {
            $inputs[$key]['id'] = $input;
            $inputs[$key]['qta'] = $request->input['qta'][$key];
        }

        foreach($inputs as $input)
        {
            DB::table('product_work')->insert([
                'input_id' => $input['id'],
                'qta' => $input['qta'],
                'work_id' => $work->id
            ]);
        }

        $checks = Check::SaveChecks($request->checks, $work);

        return redirect(route('works.index'))->with('success', 'Lavorazione Creata');

    }


    public function edit(Work $work)
    {
        $products = [''=>'']+Product::select(\DB::raw('CONCAT(codice," - ",nome_it) AS text'), 'id')->pluck('text', 'id')->toArray();
        $suppliers = [''=>'']+Company::where('fornitore', 1)->pluck('rag_soc', 'id')->toArray();
        $select = Product::orderBy('codice', 'ASC')->select(\DB::raw('CONCAT(codice," - ",nome_it) AS text'), 'id')->get();
        $tp = Product::whereNotIn('id', $work->inputs()->pluck('input_id')->toArray())->get();
        return view('jacofda::core.erp.works.edit', compact('products', 'suppliers', 'select', 'work', 'tp'));
    }

    public function update(Request $request, Work $work)
    {

        Check::UpdateChecks($request->checks, $work, $request->check_ids);

        $this->validate(request(), [
            'nome_it' => 'required',
            'codice' => 'required',
            'company_id' => 'required',
            'product_id' => 'required',
            'input.id.*' => 'required_if:input.qta.*,null',
            'input.qta.*' => 'required_if:input.id.*,null'
        ]);

            $work->nome_it = $request->nome_it;
            $work->nome_en = $request->nome_en;
            $work->nome_de = $request->nome_de;
            $work->descrizione = $request->descrizione;
            $work->versione = $request->versione;
            $work->codice = $request->codice;
            $work->company_id = $request->company_id;
            $work->product_id = $request->product_id;
            $work->cost = $request->cost;
            $work->time = $request->time;
        $work->save();


        $inputs = [];
        foreach($request->input['id'] as $key => $input)
        {
            $inputs[$key]['id'] = $input;
            $inputs[$key]['qta'] = $request->input['qta'][$key];
        }

        DB::table('product_work')->where('work_id', $work->id)->delete();

        foreach($inputs as $input)
        {
            if(!is_null($input['id']) && !is_null($input['qta']))
            {
                DB::table('product_work')->insert([
                    'input_id' => $input['id'],
                    'qta' => $input['qta'],
                    'work_id' => $work->id
                ]);
            }
        }

        return redirect(route('works.index'))->with('success', 'Lavorazione Aggiornata');
    }

    public function media(Work $work)
    {
        $model = $work;
        return view('jacofda::core.erp.works.media', compact('model'));
    }

    public function destroy(Work $work)
    {
        DB::table('product_work')->where('work_id', $work->id)->delete();
        $work->delete();
        return 'done';
    }

}
