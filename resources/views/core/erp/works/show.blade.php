@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('works.index')}}">Lavorazioni</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => $work->codice])


@section('content')


    @include('jacofda::core.erp.works.work')

    @if(count($work->product->children()) > 1 )
        @foreach($work->product->children() as $product_id => $subwork)
            @if($loop->index > 0)
                @php
                    $work = Jacofda\Klaxon\Models\Product::find($product_id)->work()->first();
                @endphp
                @include('jacofda::core.erp.works.work')
            @endif
        @endforeach
    @endif


@stop
