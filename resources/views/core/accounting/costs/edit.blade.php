@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}costs">Costi</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Modifica Prodotto'])


@section('content')

    {!! Form::model($cost, ['url' => $cost->url, 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'costForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.accounting.costs.form')
        </div>
    {!! Form::close() !!}

@stop
