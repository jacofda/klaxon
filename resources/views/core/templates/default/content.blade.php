@extends('jacofda::core.templates.default.layout')

@section('content')

    {!!Jacofda\Klaxon\Models\Template::getLastDefaultNewsletter()!!}

@stop
