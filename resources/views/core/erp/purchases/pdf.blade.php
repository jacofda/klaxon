<html>
<header>
</header>
<body >

<table width="100%" cellspacing="0" cellpadding="10" align="left">
    <tr>
        <td height="50px'" width="80%"></td>
        <td height="50px'" width="20%"></td>
    </tr>
    <tr>
        <td height="100px'" width="80%"></td>
        <td height="100px'" width="20%">
            <img style="text-align:center;display:block;margin-left:auto;margin-right:auto; width:100%;" src="{{Jacofda\Klaxon\Models\Setting::FatturaLogo()}}" />
        </td>
    </tr>
    <tr>
        <td height="20px'" width="80%"></td>
        <td height="20px'" width="20%"></td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="10" align="left">
    <tr>
        <td width="45%" style="border: 1px solid black;" class="testo" align="left">
            <b>SEDE LEGALE E INDIRIZZO DI CONSEGNA MERCE</b><br><br>
            @php $base = Jacofda\Klaxon\Models\Setting::Base() @endphp
            {{$base->rag_soc}}<br><br>
            {{$base->indirizzo}}$indirizzo<br>
            {{$base->cap}} {{$base->citta}} ({{$base->nazione}})<br>
            {{$base->piva}}

        </td>
        <td width="10%" class="testo" align="left">
            &nbsp;
        </td>
        <td width="45%" style="border: 1px solid black;" class="testo" align="left">
            @php $supplier = $order->purchases()->first()->product->supplier @endphp
            <b>FORNITORE N.{{$supplier->numero}}</b><br><br>
            {{$supplier->rag_soc}}<br><br>
            {{$supplier->indirizzo}}<br>
            {{$supplier->cap . ' ' . $supplier->citta . ' (' . $supplier->provincia.')'}}<br>
            {{$supplier->nazione}}
        </td>
    </tr>
    <tr>
        <td width="45%" style="border: 1px solid black;" class="testo" align="left">
            <b>NOSTRO PERSONALE DI RIFERIMENTO</b><br><br>
            @php $pers = Jacofda\Klaxon\Models\Setting::Personale() @endphp
            <i>Technical Office:</i><br>
            @foreach($pers['Technical Office'] as $person)
                {{$person['nome'] . ' - ' . $person['email']}}<br>
            @endforeach
            <i>Administration:</i><br>
            @foreach($pers['Administration'] as $person)
                {{$person['nome'] . ' - ' . $person['email']}}<br>
            @endforeach
        </td>
        <td width="10%" class="testo" align="left">
            &nbsp;
        </td>
        <td width="45%" valign="top" style="border: 1px solid black;" class="testo" align="left">
            <b>VOSTRO PERSONALE DI RIFERIMENTO</b><br><br>
        </td>
    </tr>
    <tr>
        <td width="100%" class="testo" align="left" colspan="3">
            &nbsp;
        </td>
    </tr>
</table>
<br>

<table width="100%" cellspacing="0" cellpadding="10" align="left">
    <tr>
        <td width="25%" style="border: 1px solid black;" class="testo" align="left">
            <b>ORDINE NUMERO</b><br><br>
            {{$order->id}}/{{$order->created_at->format('Y')}}
        </td>
        <td width="25%" style="border: 1px solid black;" class="testo" align="left">
            <b>DATA ORDINE</b><br><br>
            {{$order->created_at->format('d/m/Y')}}
        </td>
        <td width="25%" style="border: 1px solid black;" class="testo" align="left">
            <b>CONSEGNA</b><br><br>
        </td>
        <td width="25%" style="border: 1px solid black;" class="testo" align="left">
            <b>PACKING</b><br><br>
        </td>
    </tr>
    <tr>
        <td width="50%" style="border: 1px solid black;" colspan="2" class="testo" align="left">
            <b>TIPO PAGAMENTO</b><br><br>
        </td>
        <td width="50%" style="border: 1px solid black;" colspan="2" class="testo" align="left">
            <b>TELEFAX</b><br><br>
        </td>
    </tr>
    <tr>
        <td width="100%" class="testo" align="left" colspan="4">
            &nbsp;
        </td>
    </tr>
</table>
<br>

<div id="fatture" align="left" style="clear: both;">
    <table width="100%" cellpadding="10" cellspacing="0" align="left" style="border-top: 1px solid #000000;">
        <tr>
            <td width="15%" style="border: 1px solid #000000;" align="left" valign="top">
            <b>CODICE</b>
        </td>
        <td width="35%" style="border: 1px solid #000000;" align="left" valign="top">
            <b>DESCRIZIONE</b>
        </td>
        <td width="10%" style="border: 1px solid #000000;" align="center" valign="top">
            <b>UNITA</b>
        </td>
        <td width="10%" style="border: 1px solid #000000;" align="center" valign="top">
            <b>QUANTITA</b>
        </td>
        <td width="15%" style="border: 1px solid #000000;" align="center" valign="top">
            <b>PREZZO_UNITARIO</b>
        </td>
        <td width="15%" style="border: 1px solid #000000;" align="center" valign="top">
            <b>DATA CONSEGNA</b>
        </td>
    </tr>

    @foreach($order->purchases as $item)

        @if(($loop->iteration %9 == 0) && ($loop->iteration == 9))
            </table>
        </div>

        <div id="fatture" align="left" style="clear: both; page-break-before: always;">
            <table width="100%" cellpadding="10" cellspacing="0" align="left" style="margin-top:100px;border-top: 1px solid #000000;">
        @endif

        <tr>
    		<td style="width:15%; border: 1px solid #000000;" align="left" valign="top">
    			{{$item->product->codice}}
    		</td>
    		<td style="width:35%; border: 1px solid #000000;" align="left" valign="top">
    			{{$item->product->descrizione_it}}
    		</td>
    		<td style="width:10%; border: 1px solid #000000;" align="center" valign="top">
    			{{$item->product->unita}}
    		</td>
    		<td style="width:10%; border: 1px solid #000000;" align="center" valign="top">
    			{{$item->qta}}
    		</td>
    		<td style="width:15%; border: 1px solid #000000;" align="center" valign="top">
    			&euro; {{number_format($item->product->prezzo_acquisto, 2, ",", ".")}}
    		</td>
    		<td style="width:15%; border: 1px solid #000000;" align="center" valign="top">
    			{{\Carbon\Carbon::today()->addDays($order->purchase_max_consegna)->format('d/m/Y')}}
    		</td>
    	</tr>
    @endforeach

    <tr>
		<td style="width:15%; border: 1px solid #000000;" align="left" valign="top">
			&nbsp;
		</td>
		<td style="width:35%; border: 1px solid #000000;" align="left" valign="top">
			<b>TOTALE</b>
		</td>
		<td style="width:10%; border: 1px solid #000000;" align="center" valign="top">
			&nbsp;
		</td>
		<td style="width:10%; border: 1px solid #000000;" align="center" valign="top">
			&nbsp;
		</td>
		<td style="width:15%; border: 1px solid #000000;" align="center" valign="top">
			&euro; {{number_format($order->purchase_total, 2, ",", ".")}}
		</td>
		<td style="width:15%; border: 1px solid #000000;" align="center" valign="top">
			{{\Carbon\Carbon::today()->addDays($order->purchase_max_consegna)->format('d/m/Y')}}
		</td>
	</tr>
	<tr>
		<td width="100%" class="testo" align="left" colspan="6">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td width="100%" class="testo" align="left" colspan="6">
			&nbsp;
		</td>
	</tr>
</table>
</div>


</body>
</html>
