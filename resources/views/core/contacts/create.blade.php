@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}contacts">Contatti</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Crea Contatto'])


@section('content')

    {!! Form::open(['url' => url('contacts'), 'autocomplete' => 'off', 'id' => 'contactForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.contacts.form')
        </div>
    {!! Form::close() !!}

@stop
