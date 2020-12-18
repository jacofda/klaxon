<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Company, Product, Store};
use Jacofda\Klaxon\Models\Erp\{Order, Magazzini, Purchase, Log as ErpLog};
use Maatwebsite\Excel\Facades\Excel;
use Jacofda\Klaxon\Exports\PurchaseExport;

class PurchaseController extends Controller
{

//erp/orders/create/purchase
    public function create()
    {
        $products = Product::acquistabili()->get();
        return view('jacofda::core.erp.purchases.create', compact('products'));
    }

//erp/orders/create/purchase - POST
    public function store(Request $request)
    {

        $order = Order::create([
            'type' => 'Purchase',
            'comment' => $request->comment
        ]);

        $companies = [];
        foreach($request->products as $product_id => $qta)
        {

            $product = Product::find($product_id);

            Purchase::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'qta' => $qta
            ]);

            //add checklist to order
            if($product->checks()->exists())
            {
                $order->checklists()->attach($product->checks);
            }

            if(!in_array($product->company_id, $companies))
            {
                $companies[] = $product->company_id;
            }
        }

        foreach($companies as $c)
        {
            $company = Company::find($c);
            if($company->checks()->exists())
            {
                $order->checklists()->attach($company->checks);
            }
        }

        return redirect(route('erp.orders.index'))->with('message', "Ordine d'acquisto creato");
    }

//erp/orders/purchases/{order_id}
    public function show($id)
    {
        $order = Order::find($id);
        return view('jacofda::core.erp.purchases.show', compact('order'));
    }

//erp/orders/purchases/{order_id}/edit
    public function edit($id)
    {
        $order = Order::find($id);
        return view('jacofda::core.erp.purchases.edit', compact('order'));
    }

//erp/orders/purchases/{purchase}
    public function update(Request $request, Purchase $purchase)
    {
        $purchase->update(['qta_arrived' => $request->qta_arrived]);

        $store_id = Magazzini::Magazzino();
        $product_id = $purchase->product_id;
        $qta = $request->qta_arrived;
        $order_id = $purchase->order_id;
        $before = $purchase->product->qta_magazzino;

        \DB::transaction(function() use($product_id, $qta, $store_id, $order_id, $before) {
            Store::Add($product_id, $store_id, $qta);
            ErpLog::Record($before, $before + $qta, $qta, null, $store_id, $order_id, $product_id);
        });

        return 'done';
    }

//erp/orders/purchases/{order_id}/excel
    public function excel($id)
    {
        return Excel::download(new PurchaseExport(Order::find($id)), 'acquisto.xlsx');
    }

//erp/orders/purchases/{order_id}/pdf
    public function pdf($id)
    {
        $footerHtml = url('erp/pdf/footer');
        $order = Order::find($id);
        $pdf = \PDF::loadView('jacofda::core.erp.purchases.pdf', compact('order'))
                ->setPaper('a4')
                ->setOption('enable-local-file-access', true)
                ->setOption('footer-html', $footerHtml)
                ->setOption('encoding', 'UTF-8');
        return $pdf->inline();
        //return view('jacofda::core.erp.purchases.pdf', compact('order'));
    }


}
