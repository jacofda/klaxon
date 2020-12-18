@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Orders')])


@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Purchases')}}</h3>
            </div>
            <div class="card-body">

            </div>
            <div class="card-footer p-0">
                <a href="{{route('erp.orders.create.purchases')}}" class="btn btn-block btn-primary">{{__('Create')}}</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Works')}}</h3>
            </div>
            <div class="card-body">

            </div>
            <div class="card-footer p-0">
                <a href="{{route('erp.orders.create.productions')}}" class="btn btn-block btn-success">{{__('Create')}}</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Shippings')}}</h3>
            </div>
            <div class="card-body">

            </div>
            <div class="card-footer p-0">
                <a href="{{route('erp.orders.create.shippings')}}" class="btn btn-block btn-warning">{{__('Create')}}</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Movements')}}</h3>
            </div>
            <div class="card-body">

            </div>
            <div class="card-footer p-0">
                <a href="#" class="btn btn-block btn-secondary">{{__('Create')}}</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Sales')}}</h3>
            </div>
            <div class="card-body">

            </div>
            <div class="card-footer p-0">
                <a href="{{route('erp.orders.create.assemblies')}}" class="btn btn-block btn-danger">{{__('Create')}}</a>
            </div>
        </div>
    </div>
</div>

@stop
