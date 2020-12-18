@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('products.index')}}">Prodotti</a></li>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('plugins/dropzone/min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/popup/min.css')}}">
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Aggiungi media'])


@section('content')

    <div class="col-10 offset-1 mt-5">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Aggiungi media a: {{$model->nome}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('media.add')}}" class="dropzone" id="dropzoneForm">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="fallback">
                            <input name="file" type="file" multiple />
                            <input name="mediable_type" type="hidden" value="{{$model->class}}" />
                            <input name="mediable_id" type="hidden" value="{{$model->id}}" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<div class="clearfix"></div>

    @include('jacofda::components.media.images')
    @include('jacofda::components.media.files')

    <div class="mx-auto mt-5 text-center">
        <a class="btn btn-outline-primary" href="{{url($model->directory)}}"><i class="fa fa-arrow-left"></i> Torna indietro</a>
    </div>

@stop

@include('jacofda::components.media.script')
