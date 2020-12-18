@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('erp.orders.show.assemblies', $order->id)}}">{{ __('Sale') . " N.".$order->id}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Create') . ' SN'])


@section('content')

<div class="row">

    {!! Form::open(['url' => route('erp.orders.store.assemblies.sn', $order->id), 'id' => 'snFrom', 'class' => 'col-12']) !!}

        @if($order->serials()->exists())
            @foreach($inputs as $input)
                @php $product = Jacofda\Klaxon\Models\Product::find($input->id); @endphp
                @include('jacofda::core.erp.assemblies.sn.edit')
            @endforeach
        @endif

        @if(!$order->serials()->exists())
            @foreach($inputs as $input)
                @php $product = Jacofda\Klaxon\Models\Product::find($input);@endphp
                @include('jacofda::core.erp.assemblies.sn.create')
            @endforeach
        @endif

        <div class="card">
            <div class="card-footer p-0">
                <button class="btn btn-block btn-success" type="submit">{{__('Save')}}</button>
            </div>
        </div>

    {!! Form::close() !!}

</div>

@stop


@section('scripts')
<script>

    $('select[name="company_id[]"]').select2({width:'100%', placeholder:'Seleziona Cliente'});
    $('select[name="erp_order_id[]"]').select2({width:'100%', placeholder:'Seleziona Ordine'});
    $('select[name="product_id[]"]').select2({width:'100%', placeholder:'Seleziona Prodotto'});

</script>
@stop
