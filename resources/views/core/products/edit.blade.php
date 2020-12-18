@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}products">{{__('Products')}}</a></li>
        <li class="breadcrumb-item"><a href="{{$product->url}}">{{$product->nome}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Edit') . ' ' . __('Products')])


@section('content')

    {!! Form::model($product, ['url' => $product->url, 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'productForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.products.form')
        </div>
    {!! Form::close() !!}

@stop
