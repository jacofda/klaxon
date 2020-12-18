@php $base = Jacofda\Klaxon\Models\Setting::Base() @endphp

<html>
<header>
    <title>Checklist</title>
</header>
<body>
    <div style="clear: both;">
    	<table width="100%" cellspacing="0" align="left">
            <tr>
                <td width="60%" class="testo no" align="left">&nbsp;</td>
                <td width="40%" class="testo no" align="center" style="font-family: 'Arial';">
                    <h2>{{__('Ordine')}} N. {{$order->id}}</h2>
                    <h4>{{date('d/m/Y')}} {{$order->assemblies->first()->company->rag_soc}}</h4>
                </td>
            </tr>
    	</table>
    </div>

<div style="clear: both;">
    <br>
    <table width="100%">
        <tr>
            <td align="left" style="border-top: 3px solid #000000;">&nbsp;</td>
        </tr>
    </table>
    <br>
</div>

<div style="clear: both;">
    <br>
    <table width="100%">
        @foreach($order->assemblies as $item)
            <tr>
                <td style="width:30px;height:30px;border:2px solid #000;"></td>
                <td style="width:60px;height:30px;text-align:center;font-weight:bolder;">x <span style="font-size:25px;">{{$item->qta}}</span></td>
                <td>{{$item->product->codice}}</td>
                <td style="width:40px;height:30px;">{{$item->product->versione}}</td>
                <td>{{$item->product->name}}</td>
            </tr>
        @endforeach
    </table>
    <br>
</div>

<div class="si copyright" align="center" style="width: 98%; position: absolute; bottom: 0; clear: both;">
    <div style="margin-bottom:10px; margin-top: 0;height:3px; width:100%; background:#000;"></div>
	<table width="100%" style="margin-top:0;">
		<tr>
			<td width="60%" align="left" style="margin-left:-100px">
				<br><br>
				<b>{{$base->rag_soc}}</b><br>
				{{$base->indirizzo}}<br>
                {{$base->cap}} {{$base->citta}} ({{$base->nazione}})<br>
				www.klaxon-klick.com
			</td>
			<td width="40%" align="right">
				<br><br>
				IBAN: {{$base->IBAN}}<br>
				SWIFT: {{$base->SWIFT}}<br>
				{{$base->piva}} - FN 442221a<br>
				info@klaxon-klick.com
			</td>
		</tr>
	</table>
</div>

</body>
</html>
