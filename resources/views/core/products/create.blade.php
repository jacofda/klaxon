@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}products">{{__('Products')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Create') . ' ' . __('Products')])


@section('content')

    {!! Form::open(['url' => url('products'), 'autocomplete' => 'off', 'id' => 'productForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.products.form')
        </div>
    {!! Form::close() !!}

@stop
