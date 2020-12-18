@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' =>  __('Edit') . " N.".$order->id])


@section('content')

@php
    $mag_sped = Jacofda\Klaxon\Models\Erp\Magazzini::Spedizione();
@endphp

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    {{__('Edit')}} Ord. {{__('Sale')}} N.{{$order->id}} {{__('of')}} {{$order->created_at->format('d/m/Y')}}
                    <br>
                    <small>{{$order->comment}}</small>
                </h3>

                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{route('erp.orders.show.assemblies', $order->id)}}"><i class="fas fa-arrow-left"></i> Indietro</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-sm">
                        <thead class="btnone">
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Code')}}</th>
                                <th>{{__('From') . ' ' . __('Store') }}</th>
                                <th>{{__('To') . ' ' . __('Store') }}</th>
                                <th>Qta</th>
                                <th>Qta {{__('Ready')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->assemblies as $item)
                                @if($item->qta_ready == 0)
                                    <tr class="table-warning">
                                @else
                                    <tr class="table-success">
                                @endif
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->product->codice}}</td>
                                    <td>
                                        @if ($item->product->default_store_name == 'Finiti')
                                            {{__('End Products')}}
                                        @else
                                            {{__('Spare Parts')}}
                                        @endif
                                    </td>
                                    <td>{{__('Shipping')}}</td>
                                    <td id="requestedQ-{{$item->id}}">{{$item->qta}}</td>
                                    <td>
                                        <div class="form-group" style="width:250px; margin-top:5px;margin-bottom:5px;">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <a href="#" class="addP input-group-text input-group-text bg-primary"><i class="fas fa-plus"></i></a>
                                                </div>
                                                <input type="number" class="form-control form-control" min="1" value="{{$item->qta_ready}}" data-id="{{$item->id}}" id="prod-{{$item->product->id}}">
                                                <div class="input-group-append">
                                                    <a href="#" class="subP input-group-text input-group-text bg-danger"><i class="fas fa-minus"></i></a>
                                                </div>
                                                <div class="input-group-append">
                                                    <a href="#" class="saveQta input-group-text input-group-text bg-success" data-id="{{$item->id}}"><i class="fas fa-save"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="card-footer p-0">
                <a href="#" class="btn btn-block btn-primary">Crea Documenti</a>
            </div> --}}
        </div>
    </div>

</div>

@stop

@section('scripts')
<script>
$('a.addP').on('click', function(e){
    e.preventDefault();
    let val = $(this).parent('div').siblings('input').val();
    let id = $(this).parent('div').siblings('input').attr('data-id');
    if(parseInt($('td#requestedQ-'+id).text()) > parseInt(val))
    {
        $(this).parent('div').siblings('input').val(parseInt(val)+1);
    }
});

$('a.subP').on('click', function(e){
    e.preventDefault();
    let val = $(this).parent('div').siblings('input').val();
    if(parseInt(val)>0)
    {
        $(this).parent('div').siblings('input').val(parseInt(val)-1);
    }
});

$('a.saveQta').on('click', function(e){
    e.preventDefault();
    let qta_arrived = parseInt($(this).parent('div').siblings('input').val());

    if(qta_arrived === 0)
    {
        return false;
    }

    let id = parseInt($(this).attr('data-id'));
    let qta = parseInt($('td#requestedQ-'+id).text());

    axios.post("{{url('erp/orders/assemblies')}}/"+id, {
        _token: token,
        qta_arrived: qta_arrived
      })
      .then(function (response) {
        console.log(response);
        if(response.data == 'done')
        {
            if((qta == qta_arrived) && (qta_arrived > 0))
            {
                $('td#requestedQ-'+id).parent('tr').removeClass().addClass('table-success');
            }
            else
            {
                $('td#requestedQ-'+id).parent('tr').removeClass().addClass('table-warning');
            }
        }
        else
        {
            new Noty({
                text: response.data,
                type: 'error',
                theme: 'bootstrap-v4'
            }).show();
        }

      })
      .catch(function (error) {
          console.log(error);
      });
});

</script>
@stop
