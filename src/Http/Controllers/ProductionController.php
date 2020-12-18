<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Company, Invoice, Item, Product, Store};
use Jacofda\Klaxon\Models\Erp\{Order, Production, Purchase, Magazzini, Work};
use Maatwebsite\Excel\Facades\Excel;
use Jacofda\Klaxon\Models\Erp\Log as ErpLog;

class ProductionController extends Controller
{

//erp/orders/create/productions
    public function create()
    {
        session()->forget('products');
        $products = Product::assemblabili()->get();
        return view('jacofda::core.erp.productions.create', compact('products'));
    }

//erp/orders/create/productions - POST
    public function store(Request $request)
    {
        session()->put('products', $request->products);
        session()->put('comment', $request->comment);
        return redirect(route('erp.orders.preview.productions'));
    }

//erp/orders/preview/productions - GET
    public function preview()
    {
        $ordered = [];
        foreach(session('products') as $id => $qta)
        {
            $ordered[] = Product::find($id)->figli($qta);
        }

        $count = 0;$collections = [];
        foreach(session('products') as $id => $qta)
        {
            $children = Product::find($id)->children();
            $work = Product::find($id)->work;
            $collections[$count] = $children;
            $collections[$count]['qta'] = intval($qta);
        }

        return view('jacofda::core.erp.productions.preview', compact('collections', 'ordered'));
    }

//erp/orders/create-purchase/productions - POST
    public function createPurchase(Request $request)
    {
        $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        $this->createPurchaseHelper($request, $color);
        return 'erp/orders?tipo=Purchase';
    }


//erp/orders/create-production/productions - POST
    public function createProduction(Request $request)
    {
        $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        $order = $this->createProductionHelper($request, $color);
        return $order->id;
    }

//erp/orders/create-purchase-production/productions - POST
    public function createPurchaseAndProduction(Request $request)
    {
        $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        $this->createPurchaseHelper($request, $color);
        $this->createProductionHelper($request, $color);
        return 'erp/orders';
    }

/**
 * create purchase oreder
 * @param  [object] $request
 * @param  [string] $color
 * @return [void]
 */
    public function createPurchaseHelper($request, $color)
    {
        foreach($request->pa as $product)
        {
            $ids[] = $product['id'];
            $orders[$product['id']] = $product['qta'];
        }
        $company_ids = Product::whereIn('id', $ids)->distinct('company_id')->pluck('company_id')->toArray();
        foreach($company_ids as $company_id)
        {
            $products = [];
            foreach(Product::whereIn('id', $ids)->where('company_id', $company_id)->get() as $product)
            {
                if(isset($products[$product->id]))
                {
                    $products[$product->id] += $orders[$product->id];
                }
                else
                {
                    $products[$product->id] = $orders[$product->id];
                }
            }

            $order = Order::create([
                'comment' => 'Acq. Lav. '.$request->comment,
                'type' => 'Purchase',
                'color' => $color
            ]);

            //add checklist to order
            $company = Company::find($company_id);
            if($company->checks()->exists())
            {
                $order->checklists()->attach($company->checks);
            }

            foreach($products as $product_id => $qta)
            {
                Purchase::create([
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'qta' => $qta
                ]);

                //add checklist to order
                $product = Product::find($product_id);
                if($product->checks()->exists())
                {
                    $order->checklists()->attach($product->checks);
                }
            }
        }
    }

/**
 * create production order
 * @param  [object] $request
 * @param  [string] $color
 * @return [elequent] $order
 */
    public function createProductionHelper($request, $color)
    {
        $order = Order::create([
            'comment' => 'Lav. '.$request->comment,
            'type' => 'Production',
            'color' => $color
        ]);

        $items = []; $works = []; $companies = [];
        foreach($request->pl as $item)
        {
            $work = Work::find(intval($item['work']));

            $item = [
                'order_id' => $order->id,
                'input_id' => $item['id'],
                'input_qta' => intval($item['qta']),
                'input_company_id' => $work->company_id,
                'work_id' => $work->id,
                'output_id' => intval($item['output_id']),
                'output_qta' => intval($item['output_qta'])
            ];
            $items[] = $item;

            Production::create($item);


            if(!in_array($work->id, $works))
            {
                $works[] = $work->id;
            }

            if(!in_array($work->company_id, $companies))
            {
                $companies[] = $work->company_id;
            }

        }

        foreach($works as $w)
        {
            $work = Work::find($w);
            if($work->checks()->exists())
            {
                $order->checklists()->attach($work->checks);
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



        return $order;
    }


//erp/orders/productions/{order_id}
    public function show($id)
    {
        $order = Order::find($id);
        $outputs = $order->productions()->groupBy('output_id')->pluck('output_id')->toArray();
        return view('jacofda::core.erp.productions.show', compact('order', 'outputs'));
    }

//erp/orders/productions/{order_id}/output_id/edit
    public function edit($order_id, $output_id)
    {
        $order = Order::find($order_id);
        $items = $order->productions()->where('output_id', $output_id)->get();
        return view('jacofda::core.erp.productions.edit', compact('order', 'items'));
    }

//erp/orders/productions/{order_id}/output_id/complete
    public function complete($order_id, $output_id)
    {
        foreach(Order::find($order_id)->productions()->where('output_id', $output_id)->get() as $item)
        {
            $worker = $item->work->supplier;
            if(!$worker->is_home)
            {
                $product_id = $item->input_id;
                $store_id = $item->input_company_id;
                $qta = $item->input_qta;
                $before = Store::prodotto($product_id)->fornitore($item->input_company_id)->first()->qta;

                \DB::transaction(function() use($product_id, $qta, $store_id, $order_id, $before) {
                    Store::Remove($product_id, $store_id, $qta);
                    ErpLog::Record($before, $before - $qta, $qta, $store_id, null, $order_id, $product_id);
                });

            }
            $item->update(['status' => 2]);
        }

        $product_id = $output_id;
        $store_id = Magazzini::Magazzino();
        $qta = $item->output_qta;
        $before = Store::prodotto($product_id)->fornitore($store_id)->first()->qta;

        \DB::transaction(function() use($product_id, $qta, $store_id, $order_id, $before) {
            Store::Add($product_id, $store_id, $qta);
            ErpLog::Record($before, $before + $qta, $qta, null, $store_id, $order_id, $product_id);
        });


        return back();
    }

//erp/orders/productions/{production}
    public function update(Request $request, Production $production)
    {
        $worker = $production->work->supplier;
        $product_id = $production->input_id;
        $store_id = $request->company_id;
        $qta = $request->input_qta_sent;
        $order = $production->order_id;
        $before = Store::prodotto($product_id)->fornitore(Magazzini::magazzino())->first()->qta;

        //prod from klaxon e lavorazione in klaxon
        if( $worker->is_home && Work::ProductIsFromHome($request->company_id) )
        {
            //lavoratore is klaxon e product is from magazzino
            \DB::transaction(function() use($product_id, $qta, $worker, $order, $before) {
                Store::Remove($product_id, Magazzini::magazzino(), $qta);
                ErpLog::Record($before, $before - $qta, $qta, Magazzini::magazzino(), $worker->id, $order, $product_id);
            });

        }
        //prod not from klaxon e lavorazione non in kalxon spsta da magazzini klaxon a magazzini lavoratore
        elseif( !$worker->is_home &&  Work::ProductIsFromHome($request->company_id)  )
        {
            //lavoratore is NOT klaxon e product is from magazzino;
            \DB::transaction(function() use($product_id, $qta, $worker, $order, $before) {
                Store::Remove($product_id, Magazzini::magazzino(), $qta);
                ErpLog::Record($before, $before - $qta, $qta, Magazzini::magazzino(), $worker->id, $order, $product_id);

                $before = 0;
                $s = Store::prodotto($product_id)->fornitore($worker->id)->first();
                if(!is_null($s))
                {
                    $before = $s->qta;
                }
                Store::Add($product_id, $worker->id, $qta);
                ErpLog::Record($before, $before + $qta, $qta, Magazzini::magazzino(), $worker->id, $order, $product_id);
            });
        }
        elseif( !$worker->is_home &&  Work::ProductIsNotFromHome($request->company_id)  )
        {
            //lavoratore is NOT klaxon e product is NOT from magazzino; NO MOVEMENT
        }

        $production->update(['input_qta_sent' => $request->input_qta_sent]);

        $status = 0;
        foreach(Production::where('order_id', $production->order_id)->where('output_id', $production->output_id)->get() as $item)
        {
            if($item->input_qta > $item->input_qta_sent)
            {
                $status++;
            }
        }
        if($status === 0)
        {
            Production::where('order_id', $production->order_id)->where('output_id', $production->output_id)->update(['status' => 1]);
        }

        return 'done';
    }

//erp/orders/productions/{order_id}/excel
    public function excel($id)
    {
        return 'excel';
        //return Excel::download(new PurchaseExport(Order::find($id)), 'acquisto.xlsx');
    }

//erp/orders/productions/{order_id}/{output_id}/pdf
    public function pdf($order_id, $output_id)
    {
        $ddt = $this->checkItemsAreShipped($order_id, $output_id);
        dd($ddt);
        if($ddt)
        {
            return $ddt->id;
        }
        else
        {
            $ddt_id = $this->ddt($order_id, $output_id);
        }
        return redirect('erp/ddt/'.$ddt_id.'/pdf');
    }

    public function ddt($order_id, $output_id)
    {
        $order = Order::find($order_id);
        $work = $order->productions()->where('output_id', $output_id)->first()->work;
        $supplier = $work->supplier;
        $numero = Invoice::where('tipo', 'D')->whereYear('data', date('Y'))->max('numero')+1;

        $invoice = new Invoice;
            $invoice->data = date('d/m/Y');
            $invoice->numero = $numero;
            $invoice->company_id = $supplier->id;
            $invoice->riferimento = $work->nome_it;
            $invoice->tipo = 'D';
        $invoice->save();

        foreach($order->productions()->where('output_id', $output_id)->get() as $item)
        {
            $i = Item::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item->input_id,
                'descrizione' => $item->input->nome_it,
                'qta' => $item->input_qta_sent,
                'erp_order_id' => $order->id
            ]);
        }

        return $invoice->id;;
    }

    public function checkItemsAreShipped($order_id, $output_id)
    {
        foreach(Order::find($order_id)->productions()->where('output_id', $output_id)->get() as $item)
        {
            $item = Item::where('product_id', $item->input_id)->where('qta', $item->input_qta_sent)->where('erp_order_id', $order_id)->first();
            if(is_null($item))
            {
                return false;
            }
        }
        return $item->invoice_id;
    }

}
