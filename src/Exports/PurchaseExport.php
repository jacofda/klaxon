<?php

namespace Jacofda\Klaxon\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Jacofda\Klaxon\Models\Erp\Order;

class PurchaseExport implements FromView, ShouldAutoSize
{

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function view(): View
    {
        return view('jacofda::core.erp.purchases.excel',
            [
                'order' => $this->order
            ]
        );
    }

}
