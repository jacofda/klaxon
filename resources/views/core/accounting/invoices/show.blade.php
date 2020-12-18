@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}invoices">Fatture</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => $invoice->titolo])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                @include('jacofda::core.accounting.invoices.components.show-actions')
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-4">
                        <div class="row mb-3">

                            <div class="col-sm-5 pl-2 pr-2 pt-1 pb-2 bg-blue" style="border-radius:5px;">
                                <h5 class="mb-0">
                                    @if($user->can('invoices.write'))
                                        <span class="font-weight-semibold mb-0 editable"  data-name="data" data-current="{{$invoice->data->format('d/m/Y')}}">{{$invoice->data->format('d/m/Y')}}</span>
                                        <div class="template" style="display: none;">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="" value="" data-id="{{$invoice->id}}" data-model="Invoice">
                                                <div class="input-group-append">
                                                    <button class="input-group-text saveT btn-success"><i class="fa fa-save"></i></button>
                                                    <button class="input-group-text closeT btn-danger"><i class="far fa-times-circle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="font-weight-semibold mb-0">{{$invoice->data->format('d/m/Y')}}</span>
                                    @endif

                                    <small class="d-block opacity-75">Data Emissione</small>
                                </h5>
                            </div>

                            <div class="col-sm-5 offset-1 pl-2 pr-2 pt-1 pb-2 bg-blue" style="border-radius:5px;">
                                <h5 class="mb-0">
                                    <span class="font-weight-semibold mb-0">{{$invoice->tipo_pagamento}}</span>
                                    <small class="d-block opacity-75">Tipo di pagamento</small>
                                </h5>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="mb-3">
                        <div class="text-sm-right">
                            {{-- <h4 class="text-primary mb-2 mt-md-2">Invoice #49029</h4> --}}
                            <ul class="list list-unstyled mb-0">
                                <li><b>Spett.</b></li>
                                @if($user->can('companies.write'))
                                    <li><a href="{{$company->url}}/edit">{{strtoupper($company->rag_soc)}}</a></li>
                                @else
                                    <li>{{strtoupper($company->rag_soc)}}</li>
                                @endif
                                <li>{{$company->indirizzo}}, {{$company->cap}}</li>
                                <li> {{$company->citta}}, @if($company->nazione != 'IT') ({{$company->city->sigla_provincia}}) @endif {{$company->nazione}}</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row p-2 mb-4 bg-light">
                <div class="col-sm-6 p-1" style="border-bottom:1px solid #ccc;"><b>Riferimento</b> {{$invoice->riferimento}}</div>
                <div class="col-sm-6 p-1" style="border-bottom:1px solid #ccc;"><b>PIVA/C.F </b> {{$company->piva}}</div>
                <div class="col-sm-4 p-1"><b>Banca / Filiale</b></div>
                <div class="col-sm-4 p-1"><b>ABI</b></div>
                <div class="col-sm-4 p-1"><b>CAB</b></div>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                    <tr>
                        <th width="48%;">Descrizione</th>
                        <th>Qta</th>
                        <th>Prezzo</th>
                        <th>Sconto</th>
                        <th>Tot. Riga</th>
                        <th>%IVA</th>
                        <th>IVA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                        <tr id="row-{{$item->id}}" data-model="Item" data-id="{{$item->id}}">
                            <td>
                                <h6 class="mb-0">
                                    @if($item->product)
                                        {{$item->product->nome}}
                                    @endif
                                </h6>
                                @if($user->can('invoices.write'))
                                    <span class="text-muted editable" data-name="descrizione" data-current="{{$item->descrizione}}">{!!nl2br($item->descrizione)!!}</span>
                                    <div class="template" style="display: none;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="" value="" data-id="{{$item->id}}" data-model="Item">
                                            <div class="input-group-append">
                                                <button class="input-group-text saveT btn-success"><i class="fa fa-save"></i></button>
                                                <button class="input-group-text closeT btn-danger"><i class="far fa-times-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">{!!nl2br($item->descrizione)!!}</span>
                                @endif
                            </td>
                            <td>
                                @if($user->can('invoices.write'))
                                    <span class="editable" data-name="qta" data-current="{{$item->qta}}">{{$item->qta}}</span>
                                    <div class="template" style="display: none;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="" value="" data-id="{{$item->id}}" data-model="Item">
                                            <div class="input-group-append">
                                                <button class="input-group-text saveT btn-success"><i class="fa fa-save"></i></button>
                                                <button class="input-group-text closeT btn-danger"><i class="far fa-times-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span>{{$item->qta}}</span>
                                @endif

                            </td>
                            <td>
                                @if($user->can('invoices.write'))
                                    <span class="editable" data-name="importo" data-current="{{$item->importo}}">{{$item->importo_formatted}}</span>
                                    <div class="template" style="display: none;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="" value="" data-id="{{$item->id}}" data-model="Item">
                                            <div class="input-group-append">
                                                <button class="input-group-text saveT btn-success"><i class="fa fa-save"></i></button>
                                                <button class="input-group-text closeT btn-danger"><i class="far fa-times-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span>{{$item->importo_formatted}}</span>
                                @endif
                            </td>
                            <td class="">{{round($item->sconto, 2)}} %</td>
                            <td class="">{{$item->totale_riga_formatted}}</td>
                            <td class="">{{$item->perc_iva}} %</td>
                            <td class="">{{$item->iva_formatted}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-sm-6">

                    <div class="card">
                        <div class="card-header bg-light header-elements-inline">
                            <h6 class="card-title font-weight-bold">Riepilogo Iva</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @if($invoice->items()->whereNotNull('exemption_id')->exists())
                                @foreach($invoice->items_grouped_by_esenzione as $perc => $values)
                                    <li class="list-group-item">
                                        <span class="font-weight-semibold">{{$values['imponibile']}}</span>
                                        <div class="ml-auto"><b>IVA {{$values['val']}}%:</b> {{$values['iva']}} <i>{{$values['exemption']}}</i></div>
                                    </li>
                                @endforeach
                            @else
                                @foreach($invoice->items_grouped_by_perc_iva as $perc => $values)
                                    <li class="list-group-item">
                                        <span class="font-weight-semibold">{{$values['imponibile']}}</span>
                                        <div class="ml-auto"><b>IVA {{$perc}}%:</b> {{$values['iva']}}</div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light header-elements-inline">
                            <h6 class="card-title font-weight-bold">Scadenze rate e relativo importo</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                @if($user->can('invoices.write'))
                                <span class="font-weight-semibold editable" data-name="data_scadenza" data-current="{{$invoice->data_scadenza->format('d/m/Y')}}"><b>{{$invoice->data_scadenza->format('d/m/Y')}}</b></span>
                                <div class="template" style="display: none;">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="" value="" data-id="{{$invoice->id}}" data-model="Invoice">
                                        <div class="input-group-append">
                                            <button class="input-group-text saveT btn-success"><i class="fa fa-save"></i></button>
                                            <button class="input-group-text closeT btn-danger"><i class="far fa-times-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <span class="font-weight-semibold"><b>{{$invoice->data_scadenza->format('d/m/Y')}}</b></span>
                                @endif
                                <div class="ml-auto">{{$invoice->total_formatted}}</div>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="col-sm-6">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-light header-elements-inline">
                                    <h6 class="card-title font-weight-bold">Riepilogo</h6>
                                </div>
                                <ul class="list-group list-group-flush mb-0 pb-0">
                                    <li class="list-group-item">
                                        <span class="font-weight-semibold"><b>Imponibile</b></span>
                                        <div class="ml-auto">{{$invoice->imponibile_formatted}}</div>
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <span class="font-weight-semibold"><b>Ritenuta d'acconto ({{$invoice->perc_ritenuta}}%)</b></span>
                                        <div class="ml-auto">0,00 €</div>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-semibold"><b>Spese d'incasso</b></span>
                                        <div class="ml-auto">{{$invoice->spese_formatted}}</div>
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <span class="font-weight-semibold"><b>Totale IVA</b></span>
                                        <div class="ml-auto">{{$invoice->iva_formatted}}</div>
                                    </li>
                                    <li class="list-group-item bg-primary">
                                        <span class="font-weight-semibold"><b>Netto a pagare</b></span>
                                        <div class="ml-auto"><b>{{$invoice->total_formatted}}</b></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>
@stop


@section('scripts')
    <script>

    $('span.editable').on('dblclick', function(){
        let wrapper = $(this).siblings('div.template');
        wrapper.toggle();
        wrapper.find('input').attr('name', $(this).attr('data-name'));
        wrapper.find('input').attr('value', $(this).attr('data-current'));
        $(this).css('display', 'none');
    });

    $('button.closeT').on('click', function(){
        let template = $(this).parent('div').parent('div').parent('div');
        template.siblings('span.editable').html($(this).parent('div').siblings('input').val());
        template.siblings('span.editable').css('display', 'block');
        template.toggle();
    });

    $('button.saveT').on('click', function(){
        let template = $(this).parent('div').parent('div').parent('div');
        let postUrl = baseURL+'update-field';
        let input = $(this).parent('div').siblings('input');
        data = {
            model: input.attr('data-model'),
            id: input.attr('data-id'),
            _token: "{{csrf_token()}}",
            field: input.attr('name'),
            value: input.val()
        }

        $.post(postUrl, data).done(function( response ) {
            console.log(response);
            window.location.href = "{{request()->url()}}";
        });
        $(this).siblings('button.closeT').trigger('click');
    });



    </script>
@stop
