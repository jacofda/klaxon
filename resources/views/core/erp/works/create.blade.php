@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('works.index')}}">Lavorazioni</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Crea Lavorazione'])


@section('content')

    {!! Form::open(['url' => route('works.store'), 'autocomplete' => 'off', 'id' => 'workForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.erp.works.form')
        </div>
    {!! Form::close() !!}

@stop
