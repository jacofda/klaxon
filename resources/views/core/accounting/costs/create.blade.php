@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}costs">Acquisti</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Crea Acquisto'])


@section('content')

    {!! Form::open(['url' => url('costs'), 'autocomplete' => 'off', 'id' => 'costForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.accounting.costs.form')
        </div>
    {!! Form::close() !!}

@stop
