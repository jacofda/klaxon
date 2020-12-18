<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Client, Company, Product, Serial, Store};
use Jacofda\Klaxon\Models\Erp\{Assembly, Magazzini, Order, Log as ErpLog};
use Maatwebsite\Excel\Facades\Excel;

class AssemblyController extends Controller
{

//erp/orders/create/assemblies
    public function create()
    {
        $products = Product::vendibili()->get();
        $companies = [''=>'']+Client::Client()->companies()->with('clients')->select(\DB::raw('CONCAT(numero," - ",rag_soc) AS text'), 'id')->pluck('text', 'id')->toArray();
        return view('jacofda::core.erp.assemblies.create', compact('products', 'companies'));
    }

//erp/orders/create/assemblies - POST
    public function store(Request $request)
    {
        $comment = $request->comment;
        if(is_null($comment))
        {
            $comment = date('Ymd').'- Acq - '. Company::find($request->company_id)->rag_soc;
        }

        $order = Order::create([
            'type' => 'Assembly',
            'comment' => $comment,
            'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
        ]);

        foreach($request->products as $product_id => $qta)
        {
            Assembly::create([
                'order_id' => $order->id,
                'product_id' => $product_id,
                'qta' => $qta,
                'company_id' => $request->company_id
            ]);

            //Add Product CHECKLIST TO ORDER
            /*
            $product = Product::find($product_id);
            if($product->checks()->exists())
            {
                $order->checklists()->attach($product->checks);
            }
            */

        }

        //Add COMPANY CHECKLIST TO ORDER
        $company = Company::find($request->company_id);
        if($company->checks()->exists())
        {
            $order->checklists()->attach($company->checks);
        }

        return redirect(route('erp.orders.index'))->with('message', "Ordine d'acquisto creato");
    }

//erp/orders/assemblies/{order_id}
    public function show($id)
    {
        $order = Order::find($id);
        return view('jacofda::core.erp.assemblies.show', compact('order'));
    }

//erp/orders/purchases/{order_id}/edit
    public function edit($id)
    {
        $order = Order::find($id);
        return view('jacofda::core.erp.assemblies.edit', compact('order'));
    }

//erp/orders/assemblies/{assembly}
    public function update(Request $request, Assembly $assembly)
    {
        $assembly->update(['qta_ready' => $request->qta_arrived]);

        $destination_store_id = Magazzini::Spedizione();
        $origin_store_id = $assembly->product->default_store;
        $product_id = $assembly->product_id;
        $qta = $request->qta_arrived;
        $order_id = $assembly->order_id;

        if($assembly->product->default_store == Magazzini::finiti())
        {
            $before_origin = $assembly->product->qta_finiti;
        }
        else
        {
            $before_origin = $assembly->product->qta_ricambi;
        }

        $before_destination = $assembly->product->qta_spedizione;
        if($before_origin > 0)
        {
            \DB::transaction(function() use($product_id, $qta, $origin_store_id, $destination_store_id, $order_id, $before_origin, $before_destination ) {

                Store::Add($product_id, $destination_store_id, $qta);
                ErpLog::Record($before_destination, $before_destination + $qta, $qta, $origin_store_id, $destination_store_id, $order_id, $product_id);

                Store::Remove($product_id, $origin_store_id, $qta);
                //ErpLog::Record($before_origin, $before_origin - $qta, $qta, $origin_store_id, $destination_store_id, $order_id, $product_id);

            });
            return 'done';
        }

        return 'qta not available';
    }

//erp/orders/purchases/{order_id}/excel
    public function excel($id)
    {
        return Excel::download(new PurchaseExport(Order::find($id)), 'acquisto.xlsx');
    }

//erp/orders/assemblies/{order_id}/pdf
    public function checklist($id)
    {
        $order = Order::find($id);
        $pdf = \PDF::loadView('jacofda::core.erp.assemblies.checklist', compact('order'))
                ->setOption('margin-bottom', '5mm')
                ->setOption('margin-top', '5mm')
                ->setOption('margin-right', '15mm')
                ->setOption('margin-left', '15mm')
                ->setOption('encoding', 'UTF-8');
        return $pdf->inline();
        //return view('jacofda::core.erp.assemblies.checklist', compact('order'));
    }

    public function dispatch($id)
    {
        dd('todo with CRM');
    }

//erp/orders/assemblies/{order_id}/sn - GET
    public function createSn($order_id)
    {
        $order = Order::find($order_id);
        $companies = [''=>'']+Client::Client()->companies()->with('clients')->select(\DB::raw('CONCAT(numero," - ",rag_soc) AS text'), 'id')->pluck('text', 'id')->toArray();
        $company_id = $order->assemblies()->first()->company_id;
        $orders = Order::vendite()->pluck('comment', 'id')->toArray();

        $sn_product_ids = Product::requiresn()->pluck('id')->toArray();
        $snps = Product::whereIn('id',$sn_product_ids)->select(\DB::raw('CONCAT(codice," - ",nome_it) AS text'), 'id')->pluck('text', 'id')->toArray();

        $products = Product::whereIn('id', $order->assemblies()->whereIn('assemblies.product_id', $sn_product_ids)->pluck('product_id')->toArray())->get();

        $inputs = [];
        foreach($products as $product)
        {
            $qta = $order->assemblies()->where('product_id', $product->id)->first()->qta_ready;
            for($q=0;$q<$qta;$q++)
            {
                $inputs[] = $product->id;
            }
        }


        if($order->serials()->exists())
        {
            $inputs = [];
            $inputs = $order->serials;
        }



        return view('jacofda::core.erp.assemblies.sn.add', compact('order', 'companies', 'company_id', 'orders', 'order_id', 'products', 'snps', 'inputs'));
    }

//erp/orders/assemblies/{order_id}/sn - POST
    public function storeSn(Request $request, $id)
    {
        $count = count($request->id);
        $arr = [];

        if(is_null($request->id[0]))
        {
            for($x=0;$x<$count;$x++)
            {
                $arr['company_id'] = $request->company_id[$x];
                $arr['erp_order_id'] = $request->erp_order_id[$x];
                $arr['product_id'] = $request->product_id[$x];
                $arr['sn'] = $request->sn[$x];
                $arr['unlock_code'] = $request->unlock_code[$x];
                Serial::create($arr);
            }
            return back()->with('success', 'Serials Added');
        }

        for($x=0;$x<$count;$x++)
        {
            $serial = Serial::find($request->id[$x]);

            $arr['company_id'] = $request->company_id[$x];
            $arr['erp_order_id'] = $request->erp_order_id[$x];
            $arr['product_id'] = $request->product_id[$x];
            $arr['sn'] = $request->sn[$x];
            $arr['unlock_code'] = $request->unlock_code[$x];

            $serial->update($arr);
        }
        return back()->with('success', 'Serials Updated');
    }


}
