@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}roles">Ruoli</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Modifica Ruolo'])


@section('content')

    {!! Form::model($role, ['url' => url('roles/'.$role->id), 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'roleForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.roles.form')
        </div>
    {!! Form::close() !!}

@stop
