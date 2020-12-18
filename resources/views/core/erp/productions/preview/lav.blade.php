<div id="xLavorazioni" class="d-none">
@foreach ($collections as $collection)

    @php
        $multiplier = $collection['qta'];
        unset($collection['qta']);
    @endphp

    @foreach ($collection as $mother_id => $productsA)

        @php
            $main_product = Jacofda\Klaxon\Models\Product::find($mother_id);
            $work = $main_product->work;
        @endphp

        <div class="row mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-12"><h3 class="card-title mb-0">{{$main_product->nome_it}}</h3></div>
                                    <div class="col-12"><small class="mb-0">{{$work->nome_it}}</small></div>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <div class="row">
                                    <div class="col-12"><p style="line-height:2rem; margin-bottom:0;"><b>OUTPUT</b></p></div>
                                    <div class="col-12"><small class="mb-0">{{$work->product->codice}}</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
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
                                                <th class="text-center">Qta For</th>
                                                <th>Fornitore</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($productsA as $product)
                                                {{-- @if(!$product->work()->exists()) --}}
                                                    @php
                                                        $qta_work = Jacofda\Klaxon\Models\Erp\Work::inputQta($work, $product);
                                                    @endphp

                                                    <tr>
                                                        <td>
                                                            {{$product->codice}} <b>x {{$qta_work}}</b><br>
                                                            <small>{{$product->name}}</small>
                                                        </td>
                                                        <td>{{$product->costo_fornitura_formatted}}</td>
                                                        <td class="text-center">
                                                            {{$multiplier * $qta_work}}
                                                        </td>
                                                        <td style="width:100px;">
                                                            <div class="form-group" style="width:100px; margin-top:5px;margin-bottom:5px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <a href="#" class="addP input-group-text input-group-text-sm bg-primary" data-id="{{$product->id}}"><i class="fas fa-plus"></i></a>
                                                                    </div>
                                                                    <input type="number" class="form-control form-control-sm" min="1" value="{{$multiplier * $qta_work}}" id="prod-{{$product->id}}">
                                                                    <div class="input-group-append">
                                                                        <a href="#" class="subP input-group-text input-group-text-sm bg-danger" data-id="{{$product->id}}"><i class="fas fa-minus"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">{{$product->qta_magazzino}}</td>
                                                        <td class="text-center">
                                                            @if(is_null($product->stores()->fornitore($product->company_id)->first()))
                                                                0
                                                            @else
                                                                {{$product->stores()->fornitore($product->company_id)->first()->qta}}
                                                            @endif
                                                        </td>
                                                        <td><small>{{$product->supplier->rag_soc}}</small></td>
                                                    </tr>
                                                {{-- @endif --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
</div>
