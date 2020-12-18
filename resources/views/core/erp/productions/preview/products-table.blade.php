<table id="table" class="table table-sm table-borderless table-striped">
    <thead class="btnone">
        <tr>
            <th colspan="4" class="p-0" style="line-height:14px;"></th>
            <th colspan="2" class="text-center p-0" style="line-height:14px;">Disponibilità</th>
            <th class="p-0" style="line-height:14px;"></th>
        </tr>
        <tr>
            <th>Input</th>
            <th>Costo</th>
            <th>Qta Necessaria</th>
            <th class="text-center">Qta Acquisto</th>
            <th class="text-center">Qta Mag</th>
            <th class="text-center">Qta Lavoratore</th>
            <th>Fornitore</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ordered as $products)
            @foreach($products as $id => $value)

                @php
                    $work = Jacofda\Klaxon\Models\Erp\Work::find($value['work_id']);
                    $qta_work = $value['qta'];
                    $product = Jacofda\Klaxon\Models\Product::find($id);
                    $multiplier = $value['multiplier'];
                @endphp

                    <tr>
                        @if($product->acquistabile)
                            <td>
                                {{$product->codice}} <b>x {{$qta_work}}</b><br>
                                <small>{{$product->name}}</small>
                            </td>
                        @else
                            <td>
                                <span class="text-success">
                                    {{$product->codice}} <b>x {{$qta_work}}</b><br>
                                    <small>{{$product->name}}</small>
                                </span>
                            </td>
                        @endif
                        <td>{{$product->costo_fornitura_formatted}}</td>
                        <td class="text-center">
                            {{$multiplier * $qta_work}}
                        </td>
                        <td style="width:100px;">
                            @include('jacofda::core.erp.productions.preview.input-qta')
                        </td>
                        <td class="text-center">{{$product->qta_magazzino}}</td>
                        <td class="text-center">
                            @if($work->is_done_by_home)
                                {{$product->qta_magazzino}}
                            @else
                                @if(is_null($product->stores()->fornitore($work->company_id)->first()))
                                    0
                                @else
                                    {{$product->stores()->fornitore($work->company_id)->first()->qta}}
                                @endif
                            @endif
                        </td>
                        <td><small>{{$product->supplier->rag_soc}}</small></td>
                    </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
