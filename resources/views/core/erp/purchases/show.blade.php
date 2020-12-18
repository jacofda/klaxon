@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' =>   __('Purchase') . " N.".$order->id])


@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    Ord. {{__('Purchase')}} N.{{$order->id}} {{__('of')}} {{$order->created_at->format('d/m/Y')}}
                    <br>
                    <small>{{$order->comment}}</small>
                </h3>

                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{route('erp.orders.edit.purchases', $order->id)}}"><i class="fas fa-pen"></i> Qta Arrivati</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-sm table-borderless">
                        <thead class="btnone">
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Code')}}</th>
                                <th>{{__('Supplier')}}</th>
                                <th>Qta</th>
                                <th>Qta {{__('Ready')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->purchases as $item)
                                @if($item->qta_arrived == 0)
                                    <tr class="table-warning">
                                @else
                                    <tr class="table-success">
                                @endif
                                    <td>{{$item->product->nome_it}}</td>
                                    <td>{{$item->product->codice}}</td>
                                    <td>{{$item->product->supplier->rag_soc}}</td>
                                    <td>{{$item->qta}}</td>
                                    <td>{{$item->qta_arrived}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a target="_BLANK" href="{{route('erp.orders.pdf.purchases', $order->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-file-pdf"></i> Crea Pdf</a>
                <a target="_BLANK" href="{{route('erp.orders.excel.purchases', $order->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-file-excel"></i> Crea Excel</a>
            </div>
        </div>
    </div>

</div>

@stop
