<!doctype html>
@php $base = Jacofda\Klaxon\Models\Setting::Base() @endphp
<div class="si copyright" align="center" style="width: 98%; clear: both;">
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
