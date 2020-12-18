@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' =>   __('Shipping') . " N.".$order->id])


@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-outline card-warning">
            <div class="card-header ">
                <h3 class="card-title mb-0">
                    Ord. {{__('Shipping')}} N.{{$order->id}} {{__('of')}} {{$order->created_at->format('d/m/Y')}}
                    <br>
                    <small>{{$order->comment}}</small>
                </h3>
                <div class="card-tools pt-3">
                    @if($order->ShippingAllQtaAvailable)
                        <a class="btn btn-success createDDT" href="{{route('erp.orders.shippings.ddt', $order->id)}}"><i class="fas fa-truck"></i> Spedisci</a>
                    @else
                        <a class="btn btn-primary" href="{{url(request()->url())}}?update=true"><i class="fas fa-redo"></i> Aggiorna</a>
                        <a class="btn btn-warning createDDT" href="{{route('erp.orders.shippings.ddt-available', $order->id)}}"><i class="fas fa-truck"></i> Spedisci Disponibili</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @foreach($orders as $order => $items)
        @php
            $assembly = Jacofda\Klaxon\Models\Erp\Order::find($order);
        @endphp
        <div class="col-12">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        Ord. {{__('Sale')}} N.{{$assembly->id}} {{__('of')}} {{$assembly->created_at->format('d/m/Y')}}
                        <br>
                        <small>{{$assembly->comment}}</small>
                    </h3>

                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-borderless">
                            <thead class="btnone">
                                <tr>
                                    <th style="width:70%">{{__('Name')}}</th>
                                    <th>{{__('Code')}}</th>
                                    <th class="text-center">Qta</th>
                                    <th class="text-center">Qta {{__('Shipping Store')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    @php
                                        $qta = $item->qta;
                                        $qta_disp = $item->product->qta_spedizione;
                                    @endphp
                                    @if($qta > $qta_disp || $qta == 0)
                                        <tr class="bg-danger">
                                    @else
                                        <tr class="table-success">
                                    @endif

                                        <td style="width:70%"><a href="{{$item->product->url}}" target="_BLANK">{{$item->product->name}}</a></td>
                                        <td>{{$item->product->codice}}</td>
                                        <td class="text-center">{{$qta}}</td>
                                        <td class="text-center">{{$qta_disp}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <a target="_BLANK" href="{{route('erp.orders.show.assemblies', $order)}}" class="btn btn-block btn-sm btn-light"><i class="fas fa-eye"></i> {{__('See') . ' ' . __('Order')}}</a>
                </div>

            </div>
        </div>

    @endforeach

        </div>
    </div>

</div>

@stop

@section('scripts')
<script>
    $('a.createDDT').on('click', function(e){
        e.preventDefault();
        axios.get($(this).attr('href'))
          .then((response) => {
              if(response.data == 'done')
              {
                  window.location.href = "{{url('erp/ddt')}}";
              }
        });
    });
</script>
@stop
