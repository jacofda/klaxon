@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('stores.fornitori')}}">Magazzino Fornitori</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Aggiungi Prodotto a Fornitore'])


@section('content')

    {!! Form::open(['url' => route('stores.fornitori'), 'autocomplete' => 'off', 'id' => 'storeForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.stores.form')
        </div>
    {!! Form::close() !!}

@stop
