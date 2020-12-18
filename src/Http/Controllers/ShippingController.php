<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Client, Company, Invoice, Item, Product, Store};
use Jacofda\Klaxon\Models\Erp\{Assembly, Magazzini, Order, Log as ErpLog, Shipping};
use Maatwebsite\Excel\Facades\Excel;

class ShippingController extends Controller
{

//erp/orders/create/shippings
    public function create()
    {
        $companies = Client::Client()->companies()->with('clients')->select(\DB::raw('CONCAT(numero," - ",rag_soc) AS text'), 'id')->pluck('text', 'id')->toArray();
        $orders = [];
        $selected = [];
        if( request()->has('company_id') && request()->get('company_id'))
        {
            $selected = explode('-',request('company_id'));
            $orders = Order::vendite()->whereHas('assemblies', function($query) use($selected) {
                            $query->whereIn('company_id', $selected);
                        })->get();
        }
        return view('jacofda::core.erp.shippings.create', compact('orders', 'companies', 'selected'));
    }

//erp/orders/create/shippings - POST
    public function store(Request $request)
    {
        $orders = Order::whereIn('id', $request->get('orders'))->get();

        $companies = $request->get('company_id');
        $company = $companies[0];

        $comment = $request->comment;
        if(is_null($comment))
        {
            $comment = date('Ymd').'- Sped - '. Company::find($company)->rag_soc;
        }

        $shipping = Order::create([
            'type' => 'Shipping',
            'comment' => $comment,
            'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
        ]);

        foreach($orders as $order)
        {
            foreach($order->assemblies as $item)
            {
                $data = [
                    'product_id' => $item->product_id,
                    'assembly_id' => $item->id,
                    'order_id' => $shipping->id,
                    'company_id' => $item->company_id,
                    'qta' => $item->qta_ready,
                ];
                Shipping::create($data);
            }
        }

        //Add COMPANY CHECKLIST TO ORDER
        $company = Company::find($company);
        if($company->checks()->exists())
        {
            $order->checklists()->attach($company->checks);
        }

        return redirect(route('erp.orders.index'))->with('message', "Ordine di spedizione creato");
    }

//erp/orders/shippings/{order_id}
    public function show($id)
    {
        $order = Order::find($id);
        $orders = [];
        foreach($order->shippings as $shipping)
        {
            if(!in_array($shipping->assembly->order_id, $orders))
            {
                $orders[$shipping->assembly->order_id][] = $shipping;
            }
            else
            {
                $orders[$shipping->assembly->order_id][] = $shipping;
            }

            if(request()->has('update'))
            {
                if(request()->get('update'))
                {
                    $shipping->update(['qta' => $shipping->assembly->qta_ready]);
                }
            }

        }
        return view('jacofda::core.erp.shippings.show', compact('order', 'orders'));
    }

//erp/orders/purchases/{order_id}/edit
    public function edit($id)
    {
        $order = Order::find($id);
        return view('jacofda::core.erp.shippings.edit', compact('order'));
    }

//erp/orders/shippings/{assembly}
    public function update(Request $request, Assembly $assembly)
    {
        dd('todo');
    }

//erp/orders/purchases/{order_id}/excel
    public function excel($id)
    {
        return Excel::download(new PurchaseExport(Order::find($id)), 'acquisto.xlsx');
    }

//erp/orders/shippings/{order_id}/pdf
    public function checklist($id)
    {
        $order = Order::find($id);
        $pdf = \PDF::loadView('jacofda::core.erp.shippings.checklist', compact('order'))
                ->setOption('margin-bottom', '5mm')
                ->setOption('margin-top', '5mm')
                ->setOption('margin-right', '15mm')
                ->setOption('margin-left', '15mm')
                ->setOption('encoding', 'UTF-8');
        return $pdf->inline();
        //return view('jacofda::core.erp.shippings.checklist', compact('order'));
    }

    public function dispatch($id)
    {
        dd('todo with CRM');
    }

    public function ddtAvailable($id_order)
    {
        $order = Order::find($id_order);

        $post = [];$assembly_ids = [];
        foreach($order->shippings as $item)
        {
            if($item->qta == 0 || ($item->qta > $item->product->qta_spedizione))
            {
                $post[] = $item;
            }
            else
            {
                if(!in_array($item->order_id, $assembly_ids))
                {
                    $assembly_ids[] = $item->order_id;
                }
            }
        }

dd($post, $assembly_ids);

        $this->createDDT($order, $assembly_ids);

        $shipping = Order::create([
            'type' => 'Shipping',
            'comment' => $order->comment . ' extra sped',
            'color' => $order->color
        ]);

        foreach($post as $item)
        {
            $data = [
                'product_id' => $item->product_id,
                'assembly_id' => $item->id,
                'order_id' => $item->order_id,
                'company_id' => $item->company_id,
                'qta' => $item->qta_ready,
            ];
            Shipping::create($data);
        }
        return redirect(route('erp.orders.show.shippings', $shipping->id));
    }

    public function ddt($id_order)
    {
        $order = Order::find($id_order);
        $assembly_ids = array_keys ($order->assembly_order_shipping);
        $this->createDDT($order, $assembly_ids);
        return 'done';
    }

    public function createDDT($order, $assembly_ids)
    {
        $assemblies = Order::whereIn('id', $assembly_ids)->get();
        $riferimento = '';
        foreach($assemblies as $assembly)
        {
            $riferimento .= 'N. '.$assembly->id . ', ';
        }
        $riferimento = rtrim($riferimento, ', ');

        $numero = Invoice::where('tipo', 'D')->whereYear('data', date('Y'))->max('numero')+1;

        $invoice = new Invoice;
            $invoice->data = date('d/m/Y');
            $invoice->numero = $numero;
            $invoice->company_id = $order->shippings()->first()->company->id;
            $invoice->riferimento = $riferimento;
            $invoice->tipo = 'D';
        $invoice->save();

        //$invoice = Invoice::latest()->first();

        foreach($order->shippings as $item)
        {
            if($item->qta != 0 && ($item->qta <= $item->product->qta_spedizione))
            {
                $product_id = $item->product_id;
                $qta = $item->qta;
                $order_id = $order->id;
                $before = $item->product->qta_spedizione;

                $i = [
                    'invoice_id' => $invoice->id,
                    'product_id' => $product_id,
                    'descrizione' => $item->product->name,
                    'qta' => $qta,
                    'erp_order_id' => $item->assembly->order->id
                ];
                Item::create($i);

                \DB::transaction(function() use($product_id, $qta, $order_id, $before) {
                    Store::Remove($product_id, Magazzini::spedizione(), $qta);
                    ErpLog::Record($before, $before - $qta, $qta, Magazzini::spedizione(), null, $order_id, $product_id);
                });

            }
        }

        return true;

    }


//1.create invoice DDT






}
