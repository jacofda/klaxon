<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Category, Company, Product, Store};
use Jacofda\Klaxon\Models\Crm\{ProductType, ProductCategory};
use Jacofda\Klaxon\Models\Erp\Group;

class ProductController extends Controller
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
            $query = Product::filter(request());
        }
        else
        {
            $query = Product::query();
        }

        $products = $query->paginate(50);

        return view('jacofda::core.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = [''=>'']+ProductCategory::pluck('nome', 'id')->toArray();
        $types = [''=>'']+ProductType::pluck('nome', 'id')->toArray();
        $groups = [''=>'']+Group::pluck('nome', 'id')->toArray();
        $suppliers = [''=>'']+Company::where('fornitore', 1)->pluck('rag_soc', 'id')->toArray();

        return view('jacofda::core.products.create', compact('categories', 'types', 'groups', 'suppliers'));
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
            'nome_it' => 'required',
            'codice' => 'required',
        ]);

        $product = new Product;
            $product->nome_it = $request->nome_it;
            $product->nome_en = $request->nome_en;
            $product->nome_de = $request->nome_de;
            $product->descrizione_it = $request->descrizione_it;
            $product->descrizione_en = $request->descrizione_en;
            $product->descrizione_de = $request->descrizione_de;
            $product->codice = $request->codice;
            $product->codice_crm = $request->codice_crm;
            $product->codice_fornitore = $request->codice_fornitore;
            $product->versione = $request->versione;
            $product->prezzo_acquisto = $request->prezzo_acquisto;
            $product->prezzo_retail = $request->prezzo_retail;
            $product->prezzo_standard = $request->prezzo_standard;
            $product->type_id = $request->type_id;
            $product->category_id = $request->category_id;
            $product->active = $request->active;
            $product->company_id = $request->company_id;
            $product->group_id = $request->group_id;
            $product->acquistabile = $request->acquistabile;
            $product->unita = $request->unita;
            $product->qta_confezione = $request->qta_confezione;
            $product->tempo_fornitura = $request->tempo_fornitura;
            $product->costo_fornitura = $request->costo_fornitura;
            $product->tempo_fornitura = $request->tempo_fornitura;
            $product->has_sn = $request->has_sn;
            $product->qta_min = $request->qta_min;
            $product->qta_min_acquisto = $request->qta_min_acquisto;
            $product->qta_min_magazzino = $request->qta_min_magazzino;
        $product->save();

        return redirect(route('products.index'))->with('success', 'Prodotto Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        dd($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = [''=>'']+ProductCategory::pluck('nome', 'id')->toArray();
        $types = [''=>'']+ProductType::pluck('nome', 'id')->toArray();
        $groups = [''=>'']+Group::pluck('nome', 'id')->toArray();
        $suppliers = [''=>'']+Company::where('fornitore', 1)->pluck('rag_soc', 'id')->toArray();
        return view('jacofda::core.products.edit', compact('categories', 'product', 'types', 'groups', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate(request(), [
            'nome_it' => 'required',
            'codice' => 'required',
        ]);

            $product->nome_it = $request->nome_it;
            $product->nome_en = $request->nome_en;
            $product->nome_de = $request->nome_de;
            $product->descrizione_it = $request->descrizione_it;
            $product->descrizione_en = $request->descrizione_en;
            $product->descrizione_de = $request->descrizione_de;
            $product->codice = $request->codice;
            $product->codice_crm = $request->codice_crm;
            $product->codice_fornitore = $request->codice_fornitore;
            $product->versione = $request->versione;
            $product->prezzo_acquisto = $request->prezzo_acquisto;
            $product->prezzo_retail = $request->prezzo_retail;
            $product->prezzo_standard = $request->prezzo_standard;
            $product->type_id = $request->type_id;
            $product->category_id = $request->category_id;
            $product->active = $request->active;
            $product->company_id = $request->company_id;
            $product->group_id = $request->group_id;
            $product->acquistabile = $request->acquistabile;
            $product->unita = $request->unita;
            $product->qta_confezione = $request->qta_confezione;
            $product->tempo_fornitura = $request->tempo_fornitura;
            $product->costo_fornitura = $request->costo_fornitura;
            $product->tempo_fornitura = $request->tempo_fornitura;
            $product->has_sn = $request->has_sn;
            $product->qta_min = $request->qta_min;
            $product->qta_min_acquisto = $request->qta_min_acquisto;
            $product->qta_min_magazzino = $request->qta_min_magazzino;
        $product->save();

        return redirect(route('products.index'))->with('success', 'Prodotto Aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Store::where('product_id', $product->id)->delete();
        $product->delete();
        return 'done';
    }

    public function apiShow(Product $product)
    {
        return $product;
    }

    public function apiIndex()
    {
        return Product::orderBy('codice', 'ASC')->select(\DB::raw('CONCAT(codice," - ",nome_it) AS text'), 'id')->get();
    }


//products/{product}/media
    public function media(Product $product)
    {
        $model = $product;
        return view('jacofda::core.products.media', compact('model'));
    }

    public function taindex()
    {
        $ta = [];$count = 0;
        foreach(Product::all() as $product)
        {
            $ta[$count]['id'] = $product->id;
            $ta[$count]['name'] = $product->codice . " - " . $product->name;
            $count++;
        }
        return $ta;
    }


//products/orders - GET
    public function orders()
    {

    }
//products/{product}/orders
    public function ordersUpdate()
    {

    }

}
