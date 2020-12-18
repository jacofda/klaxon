<div id="fatture" align="left" style="clear: both;">
	<table width="100%" cellspacing="0" align="left">
		<tr>
			<td width="100%" colspan="3" class="testo" align="left">
				<table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo" style="background-color: white; border: solid 2px #333333; text-align: left;">
					<tr>
						<td width="25%" border="1" align="left">
							<b>{{__('Dispatch Order')}}:</b><br> {{$invoice->id}} / {{$invoice->data->format('Y')}} / {{$invoice->tipo}}
						</td>
						<td width="25%" border="1" align="left">
							<b>{{__('Date')}}:</b><br> {{$invoice->data->format('d/m/Y')}}
						</td>
                        <td width="25%" border="1" align="left">
                            <b>{{__('VAT')}}:</b><br> {{$invoice->company->piva}}
                        </td>
						<td width="25%" border="1" align="left">
							<b>{{__('Client Number')}}:</b><br> {{$invoice->company->numero}}
						</td>
					</tr>
				</table>
                <table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo" style="background-color: white; border-left: solid 2px #333333; border-right: solid 2px #333333; text-align: left;">
					<tr>
                        <td width="50%" border="1" align="left" valign="center">
							<b>{{__('Payment Method')}}:</b><br>
                            {{$invoice->payment_method}}
						</td>
						<td width="50%" border="1" align="left" valign="center">
							<b>{{__('Reference')}}:</b><br>
                            {{$invoice->riferimento}}
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo" style="background-color: white; border-top: solid 2px #333333; text-align: left; margin-top:1">
					<thead>
                        <tr class="intestazione">
							<th width="39%" border="1" valign="top" align="left" colspan="2" bgcolor="#666666">
								<b style="color: white;">Description</b>
							</th>
							<th width="6%" border="1" valign="top" align="center" bgcolor="#666666">
								<b style="color: white;">Q.ty</b>
							</th>
							<th width="15%" border="1" valign="top" align="center" bgcolor="#666666">
								<b style="color: white;">Price</b>
							</th>
							<th width="7%" border="1" valign="top" align="center" bgcolor="#666666">
								<b style="color: white;">% Dis.</b>
							</th>
							<th width="14%" border="1" valign="top" align="center" bgcolor="#666666">
								<b style="color: white;">Row total</b>
							</th>
							<th width="8%" border="1" valign="top" align="center" bgcolor="#666666">
								<b style="color: white;">% VAT</b>
							</th>
							<th width="11%" border="1" valign="top" align="center" bgcolor="#666666">
								<b style="color: white;">VAT</b>
							</th>
						</tr>
					</thead>
                    <tbody>

                        <tr>
                            <td colspan="2" style="border-left: 1px solid #000000;border-right: 1px solid #000000;"></td>
                            <td style="border-right: 1px solid #000000;text-align:center;" width="6%"></td>
                            <td style="border-right: 1px solid #000000;text-align:center;" width="15%"></td>
                            <td style="border-right: 1px solid #000000;text-align:center;" width="7%"></td>
                            <td style="border-right: 1px solid #000000;text-align:center;" width="14%"></td>
                            <td style="border-right: 1px solid #000000;text-align:center;" width="8%"></td>
                            <td style="border-right: 1px solid #000000;text-align:center;" width="11%"></td>
                        </tr>

                        @foreach($orders as $order_id)
                            @php $order = Jacofda\Klaxon\Models\Erp\Order::find($order_id) @endphp
                            <tr>
                                <td colspan="2" style="background:#bbb;padding:8px 5px; border-left: 1px solid #000000;border-right: 1px solid #000000;" width="39%"><b>{{__($order->type)}}</b>: N.{{$order->id}}<br>{{$order->comment}}</b></td>
                                <td style="border-right: 1px solid #000000;text-align:center;" width="6%"></td>
                                <td style="border-right: 1px solid #000000;text-align:center;" width="15%"></td>
                                <td style="border-right: 1px solid #000000;text-align:center;" width="7%"></td>
                                <td style="border-right: 1px solid #000000;text-align:center;" width="14%"></td>
                                <td style="border-right: 1px solid #000000;text-align:center;" width="8%"></td>
                                <td style="border-right: 1px solid #000000;text-align:center;" width="11%"></td>
                            </tr>

                            @foreach($invoice->items()->where('erp_order_id', $order_id)->get() as $item)
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
                        <tr>
                            <td colspan="2" style="border-left: 1px solid #000000;border-right: 1px solid #000000;border-bottom: 1px solid #000000;"></td>
                            <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;text-align:center;" width="6%"></td>
                            <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;text-align:center;" width="15%"></td>
                            <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;text-align:center;" width="7%"></td>
                            <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;text-align:center;" width="14%"></td>
                            <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;text-align:center;" width="8%"></td>
                            <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;text-align:center;" width="11%"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>

<div id="fatture" align="left" style="clear: both;">
<br><br>
<table width="100%" cellpadding="5" cellspacing="0" align="center" class="testo" style="background-color: white; border-top: solid 2px #333333;">
    <tr>
    <td colspan="2" class="dett_fatt" align="left" style="border: 1px solid #000000;">
    	<b>Dispatch date:</b> &nbsp;{{$invoice->ddt->data->format('d/m/Y')}}
    </td>
    <td colspan="3" class="dett_fatt" align="left" style="border: 1px solid #000000;">
    	<b>Carrier:</b> &nbsp; @if($invoice->ddt->delivery_company_id){{Jacofda\Klaxon\Models\DeliveryCompany::find($invoice->ddt->delivery_company_id)->name}} @endif
    </td>
    <td colspan="3" class="dett_fatt" align="left" style="border: 1px solid #000000;">
    	<b>Dispatch type:</b> &nbsp; {{$invoice->ddt->tipo_spedizione}}
    </td>
    </tr>
    <tr>
    <td colspan="4" class="dett_fatt" align="left" style="border: 1px solid #000000;">
    	<b>Notes:</b> &nbsp; {{$invoice->ddt->note_spedizione}}
    </td>
    <td colspan="2" class="dett_fatt" align="left" style="border: 1px solid #000000;">
    	<b>Packages:</b> &nbsp; {{$invoice->ddt->colli_spedizione}}
    </td>
    <td colspan="2" class="dett_fatt" align="left" style="border: 1px solid #000000;">
    	<b>Weight:</b> &nbsp; {{$invoice->ddt->peso_spedizione}} Kg
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
