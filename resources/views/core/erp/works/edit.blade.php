@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('works.index')}}">Lavorazioni</a></li>
    <li class="breadcrumb-item"><a href="{{route('works.show', $work->id)}}">{{$work->codice}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Edit') . ' ' . $work->codice])


@section('content')

    {!! Form::model($work, ['url' => route('works.update', $work->id), 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'workForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.erp.works.form')
        </div>
    {!! Form::close() !!}

@stop
