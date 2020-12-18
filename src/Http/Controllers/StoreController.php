<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jacofda\Klaxon\Models\{Company, Product, Store};
use Jacofda\Klaxon\Models\Erp\Magazzini;

class StoreController extends Controller
{

    public function index()
    {

        if(request()->has('id'))
        {
            $products = Product::where('id', request('id'))->with('stores')->paginate(25);
        }
        elseif(request()->has('acquistabile'))
        {
            $query = Product::with('stores');
            if(request('acquistabile') != '')
            {
                $query = $query->where('acquistabile', request('acquistabile'));
            }
            if(request('group_id') != '')
            {
                $query = $query->where('group_id', request('group_id'));
            }

            $products = $query->paginate(50);
        }
        else
        {
            $products = Product::with('stores')->paginate(50);
        }
        return view('jacofda::core.stores.index', compact('products'));
    }

    public function create()
    {
        $suppliers = [''=>'']+Company::where('fornitore', 1)->pluck('rag_soc', 'id')->toArray();
        $products = [''=>'']+Product::select(\DB::raw('CONCAT(codice," - ",nome_it) AS text'), 'id')->pluck('text', 'id')->toArray();
        return view('jacofda::core.stores.add-to-fornitore', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $store = Store::where('product_id', $request->product_id)->where('company_id', $request->company_id)->first();

        if($store)
        {
            $store->update(['qta' => $request->qta]);
        }
        else
        {
            Store::create([
                'product_id' => $request->product_id,
                'company_id' => $request->company_id,
                'qta' => $request->qta
            ]);
        }

        $rag_soc = Company::find($request->company_id)->rag_soc;

        return redirect(route('stores.fornitori'))->with('success', 'Prodotto aggiunto a '.$rag_soc);
    }

    public function indexFornitori()
    {
        $stores = Store::whereNotIn('company_id', Magazzini::production())->with('product')->get();
        return view('jacofda::core.stores.fornitori', compact('stores'));
    }

    public function update(Request $request)
    {
        $store = Store::where('product_id', $request->product_id)->where('company_id', $request->company_id)->first();

        if($store)
        {
            $store->update(['qta' => $request->qta]);
        }
        else
        {
            Store::create([
                'product_id' => $request->product_id,
                'company_id' => $request->company_id,
                'qta' => $request->qta
            ]);
        }

        return 'done';
    }

    public function taindex()
    {
        $ta = [];$count = 0;
        foreach(Product::with('stores')->get() as $product)
        {
            $ta[$count]['id'] = $product->id;
            $ta[$count]['name'] = $product->codice . " - " . $product->name;
            $count++;
        }
        return $ta;
    }


}
