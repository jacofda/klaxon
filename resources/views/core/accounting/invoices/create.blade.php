@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}invoices">Fatture</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Crea Fattura'])


@section('content')

    {!! Form::open(['url' => url('invoices'), 'autocomplete' => 'off', 'id' => 'invoiceForm', 'class' => 'form-horizontal']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.accounting.invoices.form')
        </div>
    {!! Form::close() !!}



@include('jacofda::core.accounting.invoices.form-components.modal-storno')

@stop
