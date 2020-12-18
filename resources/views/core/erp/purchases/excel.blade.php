@php
    $supplier = $order->purchases()->first()->product->supplier;
    $base = Jacofda\Klaxon\Models\Setting::Base();
    $pers = Jacofda\Klaxon\Models\Setting::Personale();
@endphp

<table>
    <thead>
        <tr>
            <th>SEDE LEGALE E INDIRIZZO DI CONSEGNA MERCE</th>
            <th></th>
            <th>FORNITORE N.{{$supplier->numero}}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$base->rag_soc}}</td>
            <td></td>
            <td>{{$supplier->rag_soc}}</td>
        </tr>
        <tr>
            <td>{{$base->indirizzo}}</td>
            <td></td>
            <td>{{$supplier->indirizzo}}</td>
        </tr>
        <tr>
            <td>{{$base->cap}} {{$base->citta}} ({{$base->nazione}})</td>
            <td></td>
            <td>{{$supplier->cap . ' ' . $supplier->citta . ' (' . $supplier->provincia.')'}}</td>
        </tr>
        <tr>
            <td>{{$base->piva}}</td>
            <td></td>
            <td>{{$supplier->nazione}}</td>
        </tr>
    </tbody>
</table>



<table>
    <thead>
        <tr>
            <th>NOSTRO PERSONALE DI RIFERIMENTO</th>
            <th></th>
            <th>VOSTRO PERSONALE DI RIFERIMENTO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Technical Office:</td>
            <td></td>
            <td></td>
        </tr>
        @foreach($pers['Technical Office'] as $person)
            <tr>
                <td>{{$person['nome'] . ' - ' . $person['email']}}</td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td>Administration:</td>
            <td></td>
            <td></td>
        </tr>
        @foreach($pers['Administration'] as $person)
            <tr>
                <td>{{$person['nome'] . ' - ' . $person['email']}}</td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>


<table>
    <thead>
        <tr>
            <th>ORDINE NUMERO</th>
            <th>DATA ORDINE</th>
            <th>CONSEGNA</th>
            <th>PACKING</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$order->id}}/{{$order->created_at->format('Y')}}</td>
            <td>{{$order->created_at->format('d/m/Y')}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>TIPO PAGAMENTO</td>
            <td></td>
            <td>TELEFAX</td>
            <td></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>CODICE</th>
            <th>DESCRIZIONE</th>
            <th>UNITA</th>
            <th>QUANTITA</th>
            <th>PREZZO_UNITARIO</th>
            <th>DATA CONSEGNA</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->purchases as $item)
            <tr>
        		<td>
        			{{$item->product->codice}}
        		</td>
        		<td>
        			{{$item->product->descrizione_it}}
        		</td>
        		<td>
        			{{$item->product->unita}}
        		</td>
        		<td>
        			{{$item->qta}}
        		</td>
        		<td>
        			&euro; {{number_format($item->product->prezzo_acquisto, 2, ",", ".")}}
        		</td>
        		<td>
        			{{\Carbon\Carbon::today()->addDays($order->purchase_max_consegna)->format('d/m/Y')}}
        		</td>
        	</tr>
        @endforeach
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                TOTALE
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                &euro; {{number_format($order->purchase_total, 2, ",", ".")}}
            </td>
            <td>
                {{\Carbon\Carbon::today()->addDays($order->purchase_max_consegna)->format('d/m/Y')}}
            </td>
        </tr>
    </tbody>
</table>
