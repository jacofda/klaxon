@foreach($ddt->items as $item)
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
