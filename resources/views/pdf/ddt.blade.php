<div id="fatture" align="left" style="clear: both;">
	<table width="100%" cellspacing="0" align="left">
		<tr>
			<td width="100%" colspan="3" class="testo" align="left">
				<table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo" style="background-color: white; border: solid 2px #333333; text-align: left;">
					<tr>
						<td width="25%" border="1" align="left">
							<b>{{__('Dispatch Order')}}:</b><br> {{$ddt->id}} / {{$ddt->data->format('Y')}} / {{$ddt->tipo}}
						</td>
						<td width="25%" border="1" align="left">
							<b>{{__('Date')}}:</b><br> {{$ddt->data->format('d/m/Y')}}
						</td>
                        <td width="25%" border="1" align="left">
                            <b>{{__('VAT')}}:</b><br> {{$supplier->piva}}
                        </td>
						<td width="25%" border="1" align="left">
							<b>{{__('Client Number')}}:</b><br> {{$supplier->numero}}
						</td>
					</tr>
				</table>
                <table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo" style="background-color: white; border-left: solid 2px #333333; border-right: solid 2px #333333; text-align: left;">
					<tr>
						<td  border="1" align="left" valign="center">
							<b>{{__('Reference')}}:</b><br>
                            {{$ddt->riferimento}}
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo" style="background-color: white; border-top: solid 2px #333333; text-align: left; margin-top:1">
					<thead>
                        <tr class="intestazione">
							<th width="90%" border="1" valign="top" align="left" colspan="2" bgcolor="#666666">
								<b style="color: white;">Description</b>
							</th>
							<th width="10%" border="1" valign="top" align="center" bgcolor="#666666">
								<b style="color: white;">Q.ty</b>
							</th>
						</tr>
					</thead>
                    <tbody>

                        <tr>
                            <td colspan="2" style="border-left: 1px solid #000;border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;text-align:center;" width="10%"></td>
                            {{-- <td style="border-right: 1px solid #000;text-align:center;" width="15%"></td>
                            <td style="border-right: 1px solid #000;text-align:center;" width="7%"></td>
                            <td style="border-right: 1px solid #000;text-align:center;" width="14%"></td>
                            <td style="border-right: 1px solid #000;text-align:center;" width="8%"></td>
                            <td style="border-right: 1px solid #000;text-align:center;" width="11%"></td> --}}
                        </tr>

                        @foreach($orders as $order_id)
                            @php $order = Jacofda\Klaxon\Models\Erp\Order::find($order_id) @endphp
                            <tr>
                                <td colspan="2" style="background:#bbb;padding:8px 5px; border-left: 1px solid #000;border-right: 1px solid #000;" width="39%"><b>{{__($order->type)}}</b>: N.{{$order->id}}<br>{{$order->comment}}</b></td>
                                <td style="border-right: 1px solid #000;text-align:center;" width="10%"></td>
                                {{-- <td style="border-right: 1px solid #000;text-align:center;" width="15%"></td>
                                <td style="border-right: 1px solid #000;text-align:center;" width="7%"></td>
                                <td style="border-right: 1px solid #000;text-align:center;" width="14%"></td>
                                <td style="border-right: 1px solid #000;text-align:center;" width="8%"></td>
                                <td style="border-right: 1px solid #000;text-align:center;" width="11%"></td> --}}
                            </tr>

                            @foreach($ddt->items()->where('erp_order_id', $order_id)->get() as $item)
                                <tr>
                                    <td style="border-left: 1px solid #000;border-right: 1px solid #000;" colspan="2" width="39%"><b>{{$item->product->name}}</b><br>{{$item->product->codice}}</td>
                                    <td valign="top" style="border-right: 1px solid #000;text-align:center;" width="10%">{{$item->qta}}</td>
                                    {{-- <td valign="top" style="border-right: 1px solid #000;text-align:center;" width="15%">{{$item->product->prezzo_retail}}</td>
                                    <td valign="top" style="border-right: 1px solid #000;text-align:center;" width="7%">%discount</td>
                                    <td valign="top"  style="border-right: 1px solid #000;text-align:center;" width="14%">{{$item->product->prezzo_retail*$item->qta}}</td>
                                    <td valign="top" style="border-right: 1px solid #000;text-align:center;" width="8%">%vat</td>
                                    <td valign="top" style="border-right: 1px solid #000;text-align:center;" width="11%">ivato</td> --}}
                                </tr>
                            @endforeach

                        @endforeach
                        <tr>
                            <td colspan="2" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"></td>
                            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;" width="10%"></td>
                            {{-- <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;" width="15%"></td>
                            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;" width="7%"></td>
                            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;" width="14%"></td>
                            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;" width="8%"></td>
                            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;" width="11%"></td> --}}
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>

<div id="fatture" align="left" style="clear: both;">
<br><br>
<table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo">
    <tr>
    <td colspan="2" class="dett_fatt" align="left" style="border: 1px solid #000;">
    	<b>Dispatch date:</b> &nbsp;{{$ddt->data->format('d/m/Y')}}
    </td>
    <td colspan="3" class="dett_fatt" align="left" style="border: 1px solid #000;border-left:none;">
    	<b>Carrier:</b> &nbsp; @if($ddt->delivery_company_id){{Jacofda\Klaxon\Models\DeliveryCompany::find($ddt->delivery_company_id)->name}} @endif
    </td>
    <td colspan="3" class="dett_fatt" align="left" style="border: 1px solid #000;border-left:none;">
    	<b>Dispatch type:</b> &nbsp; {{$ddt->tipo_spedizione}}
    </td>
    </tr>
    <tr>
    <td colspan="4" class="dett_fatt" align="left" style="border: 1px solid #000;border-top:none;">
    	<b>Notes:</b> &nbsp; {{$ddt->note_spedizione}}
    </td>
    <td colspan="2" class="dett_fatt" align="left" style="border: 1px solid #000;border-left:none;border-top:none;">
    	<b>Packages:</b> &nbsp; {{$ddt->colli_spedizione}}
    </td>
    <td colspan="2" class="dett_fatt" align="left" style="border: 1px solid #000;border-left:none;border-top:none;">
    	<b>Weight:</b> &nbsp; {{$ddt->peso_spedizione}} Kg
    </td>
    </tr>
    <tr>
    <td align="left">
    	&nbsp;
    </td>
    <td align="left">
    	&nbsp;
    </td>
    <td align="left">
    	&nbsp;
    </td>
    <td align="left">
    	&nbsp;
    </td>
    <td align="left">
    	&nbsp;
    </td>
    <td align="left">
    	&nbsp;
    </td>
    <td align="left">
    	&nbsp;
    </td>
    <td align="left">
    	&nbsp;
    </td>
    </tr>
</table>
</div>

<table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo" style="background-color: white;">
    <tr>
        <td align="left" style="border: 1px solid #000;">
            <b>Motor vehicle</b>
            <br><br>
        </td>
        <td align="left" style="border: 1px solid #000;border-left:none;">
            <b>Driver</b>
            <br><br>
        </td>
        <td align="left" style="border: 1px solid #000;border-left:none;">
            <b>Signature for receipt</b>
            <br><br>
        </td>
    </tr>
    <tr>
        <td colspan="8" align="left" style="border: 1px solid #000; border-top: none;"><br></td>
    </tr>
</table>
