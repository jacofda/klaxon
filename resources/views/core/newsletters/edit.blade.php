@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}newsletters">Newsletters</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Modifica Newsletter'])

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
@stop


@section('content')

    {!! Form::model($newsletter, ['url' => $newsletter->url, 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'newsletterForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.newsletters.form')
        </div>
    {!! Form::close() !!}

@stop

@section('scripts')
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
@stop
