@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}companies">Aziende</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Crea Azienda'])


@section('content')

    {!! Form::open(['url' => url('companies'), 'autocomplete' => 'off', 'id' => 'companyForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.companies.form')
        </div>
    {!! Form::close() !!}

@stop
