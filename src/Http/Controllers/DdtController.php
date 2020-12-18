<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Jacofda\Klaxon\Models\{Company, DeliveryCompany,Invoice, Item, Product, Store};
use Jacofda\Klaxon\Models\Erp\{Ddt, Magazzini};

class DdtController extends Controller
{

    public function index()
    {
        $ddts = Invoice::ddt()->get();
        return view('jacofda::core.erp.ddts.index', compact('ddts'));
    }

    public function show($invoice_id)
    {
        dd('show');
        return view();
    }

    public function edit($invoice_id)
    {
        $ddt = Invoice::find($invoice_id);
        $companies = Company::pluck('rag_soc', 'id')->toArray();

        $deliveryCompanies = ['' => '']+DeliveryCompany::pluck('name', 'id')->toArray();
        $dispatchTypes = config('klaxon.dispatchTypes');

        $orders = $ddt->items('items.erp_order_id')->distinct()->pluck('items.erp_order_id');

        $products = [];
        $products[0] = "";
        $count = 1;
        $pr = Product::orderBy('codice', 'ASC')->select(\DB::raw('CONCAT(codice," - ",nome_it) AS text'), 'id')->get();
        foreach($pr as $p)
        {
            $products[$count]['text'] = $p->text;
            $products[$count]['id'] = $p->id;
            $count++;
        }
        return view('jacofda::core.erp.ddts.edit', compact('ddt', 'companies', 'dispatchTypes', 'deliveryCompanies', 'orders', 'products'));
    }
//erp/ddt/{invoice_id}/add-product - POST
    public function addProduct(Request $request, $invoice_id)
    {
        $product = Product::find($request->product_id);
        Item::create([
            'product_id' => $product->id,
            'descrizione' => $product->name,
            'qta' => $request->qta,
            'invoice_id' => $invoice_id,
            'erp_order_id' => $request->order_id
        ]);
        return 'done';
    }


    public function update(Request $request, $invoice_id)
    {
        $ddt = Invoice::find($invoice_id);
            $ddt->numero = $request->numero;
            $ddt->data = $request->data;
            $ddt->data_registrazione = $request->data;
            $ddt->company_id = $request->company_id;
            $ddt->riferimento = $request->riferimento;
            $ddt->delivery_company_id = $request->delivery_company_id;
            $ddt->tipo_spedizione = $request->tipo_spedizione;
            $ddt->note_spedizione = $request->note_spedizione;
            $ddt->colli_spedizione = $request->colli_spedizione;
            $ddt->peso_spedizione = $request->colli_spedizione;
        $ddt->save();
        return redirect(route('erp.ddt.index'))->with('message', 'DDT aggiornato');
    }


    public function destroy($invoice_id)
    {
        $ddt = Invoice::find($invoice_id);
        foreach($ddt->items as $item)
        {
            $product_id = $item->product_id;
            $qta = $item->qta;
            $before = $item->product->qta_spedizione;

            //reset qta in magazzino spedizioni
            Store::Add($product_id, Magazzini::spedizione(), $qta);
            $item->delete();
        }
        $ddt->delete();
        return 'done';
    }

    public function pdf($invoice_id)
    {
        $ddt = Invoice::find($invoice_id);
        $supplier = $ddt->company;
        $orders = $ddt->items('items.erp_order_id')->distinct()->pluck('items.erp_order_id');

        //return view('jacofda::core.erp.ddts.pdf.show', compact('ddt', 'supplier', 'orders'));

        $pdf = \PDF::loadView('jacofda::core.erp.ddts.pdf.show', compact('ddt', 'supplier', 'orders'))
                ->setOption('margin-bottom', '5mm')
                ->setOption('margin-top', '5mm')
                ->setOption('margin-right', '15mm')
                ->setOption('margin-left', '15mm')
                ->setOption('encoding', 'UTF-8');
        return $pdf->inline();
    }

}
