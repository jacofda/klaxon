@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' =>   __('Sale') . " N.".$order->id])


@section('content')


@php
$buyer = $order->assemblies()->first()->company;
@endphp


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="display:inline-grid;">
                <h3 class="card-title mb-0">
                    Ord. {{__('Sale')}} N.{{$order->id}} {{__('of')}} {{$order->created_at->format('d/m/Y')}}
                </h3>
                <p class="my-0"><a target="_BLANK" href="{{$buyer->url}}">{{$buyer->rag_soc}}</a></p>
                <small>{{$order->comment}}</small>
            </div>
        </div>
    </div>
</div>

@include('jacofda::core.erp.productions.show.quality-control')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{route('erp.orders.edit.assemblies', $order->id)}}"><i class="fas fa-pen"></i> Qta Arrivati</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-sm table-borderless">
                        <thead class="btnone">
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Code')}}</th>
                                <th>Qta</th>
                                <th>Qta {{__('Ready')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->assemblies as $item)
                                @if($item->qta_ready == 0)
                                    <tr class="table-warning">
                                @else
                                    <tr class="table-success">
                                @endif
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->product->codice}}</td>
                                    <td>{{$item->qta}}</td>
                                    <td>{{$item->qta_ready}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-8">
                        <a target="_BLANK" href="{{route('erp.orders.checklist.assemblies', $order->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-tasks"></i> Checklist</a>
                        <a target="_BLANK" href="{{route('erp.orders.dispatch.assemblies', $order->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-shipping-fast"></i> {{__('Dispatch Order')}}</a>
                    </div>
                    @if($order->has_sn_products)
                        <div class="col-sm-4 text-right">
                            @if($order->sn_has_been_set)
                                <a href="{{route('erp.orders.create.assemblies.sn', $order->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-key"></i> {{__('Edit') .' SN'}}</a>
                            @else
                                <a href="{{route('erp.orders.create.assemblies.sn', $order->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-key"></i> {{__('Create') .' SN'}}</a>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

@stop
