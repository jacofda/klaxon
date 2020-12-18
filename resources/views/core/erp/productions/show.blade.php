@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Work')." N.".$order->id])


@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="display:inline-grid;">
                    <h3 class="card-title mb-0">
                        Ord. {{__('Work')}} N.{{$order->id}} {{$order->created_at->format('d/m/Y')}}
                    </h3>
                    <small>{{$order->comment}}</small>
                </div>
            </div>
        </div>
    </div>


    @include('jacofda::core.erp.productions.show.quality-control')


@foreach($outputs as $output)

    @php
        $work = $order->productions()->where('output_id', $output)->first()->work
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="display:inline-grid;">
                    <h4 class="mb-0 text-right">
                        <span class="badge badge-primary">{{$order->productions()->where('output_id', $output)->first()->output_qta}}</span> x <span class="badge badge-light">{{$order->productions()->where('output_id', $output)->first()->work->product->name}}</span> <span class="badge badge-dark">{{$order->productions()->where('output_id', $output)->first()->work->product->codice}}</span>
                    </h4>
                    <h6>{{__('Done by')}}: {{$work->supplier->rag_soc}}</h6>
                </div>

                <div class="card-body">
                    <div class="row">

                        @include('jacofda::core.erp.productions.show.inputs')

                        @include('jacofda::core.erp.productions.show.actions')

                    </div>
                </div>
                @if($order->productions()->groupBy('output_id')->first()->status !== 0)
                    <div class="card-footer text-right">
                        <a target="_BLANK" href="{{route('erp.orders.pdf.productions', ['order_id' => $order->id, 'output_id' => $output])}}" class="btn btn-sm btn-primary"><i class="fas fa-truck"></i> {{__('Create')}} DDT</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endforeach



@stop

@section('scripts')
<script>
    $('body').addClass('sidebar-collapse');
</script>
@stop
