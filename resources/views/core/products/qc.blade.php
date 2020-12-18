@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('products.index')}}">Prodotti</a></li>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('plugins/dropzone/min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/popup/min.css')}}">
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Add') . ' Quality Control'])


@section('content')
@stop
