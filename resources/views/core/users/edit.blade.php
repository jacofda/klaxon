@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}users">Utenti</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Modifica Utente'])


@section('content')

    {!! Form::model($element, ['url' => url('users/'.$element->id), 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'userForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.users.form')
        </div>
    {!! Form::close() !!}

@stop
