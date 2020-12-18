@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}companies">Aziende</a></li>
    <li class="breadcrumb-item"><a href="{{$company->url}}">{{$company->rag_soc}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Modifica Azienda'])


@section('content')

    {!! Form::model($company, ['url' => $company->url, 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'companyForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.companies.form')
        </div>
    {!! Form::close() !!}

@stop
