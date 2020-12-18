@php
    $items = $order->assembly_order_shipping;
@endphp

@foreach($order->assembly_order_in_shipping as $order_id)

    @php
        $purchase = Jacofda\Klaxon\Models\Erp\Order::find($order_id);
    @endphp

    <tr>
        <td colspan="2" style="background:#bbb;padding:8px 5px; border-left: 1px solid #000000;border-right: 1px solid #000000;" width="39%"><b>{{$purchase->name}}<br>{{$purchase->comment}}</b></td>
        <td style="border-right: 1px solid #000000;text-align:center;" width="6%"></td>
        <td style="border-right: 1px solid #000000;text-align:center;" width="15%"></td>
        <td style="border-right: 1px solid #000000;text-align:center;" width="7%"></td>
        <td style="border-right: 1px solid #000000;text-align:center;" width="14%"></td>
        <td style="border-right: 1px solid #000000;text-align:center;" width="8%"></td>
        <td style="border-right: 1px solid #000000;text-align:center;" width="11%"></td>
    </tr>

    @foreach($items[$order_id] as $item)
        <tr>
            <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="2" width="39%"><b>{{$item->product->name}}</b><br>{{$item->product->codice}}</td>
            <td valign="top" style="border-right: 1px solid #000000;text-align:center;" width="6%">{{$item->qta}}</td>
            <td valign="top" style="border-right: 1px solid #000000;text-align:center;" width="15%">{{$item->product->prezzo_retail}}</td>
            <td valign="top" style="border-right: 1px solid #000000;text-align:center;" width="7%">%discount</td>
            <td valign="top"  style="border-right: 1px solid #000000;text-align:center;" width="14%">{{$item->product->prezzo_retail*$item->qta}}</td>
            <td valign="top" style="border-right: 1px solid #000000;text-align:center;" width="8%">%vat</td>
            <td valign="top" style="border-right: 1px solid #000000;text-align:center;" width="11%">ivato</td>
        </tr>
    @endforeach
@endforeach
