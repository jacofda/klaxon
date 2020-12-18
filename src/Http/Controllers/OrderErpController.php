<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Company, Product};
use Jacofda\Klaxon\Models\Erp\{Order, Purchase};

class OrderErpController extends Controller
{


    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(40);
        return view('jacofda::core.erp.orders.index', compact('orders'));
    }

    public function indexSales()
    {
        $orders = Order::vendite()->orderBy('created_at', 'DESC')->paginate(40);
        return view('jacofda::core.erp.orders.types.index-sales', compact('orders'));
    }

    public function indexPurchases()
    {
        $orders = Order::acquisti()->orderBy('created_at', 'DESC')->paginate(40);
        return view('jacofda::core.erp.orders.types.index-purchases', compact('orders'));
    }

    public function indexWorks()
    {
        $orders = Order::lavorazioni()->orderBy('created_at', 'DESC')->paginate(40);
        return view('jacofda::core.erp.orders.types.index-works', compact('orders'));
    }

    public function indexShippings()
    {
        $orders = Order::spedizioni()->orderBy('created_at', 'DESC')->paginate(40);
        return view('jacofda::core.erp.orders.types.index-shippings', compact('orders'));
    }

    public function create()
    {
        return view('jacofda::core.erp.orders.create');
    }


    public function destroy(Order $order)
    {
        if($order->type === 'Purchase')
        {
            foreach($order->purchases as $purchase)
            {
                $purchase->delete();
            }
        }
        $order->delete();
        return 'done';
    }


}
