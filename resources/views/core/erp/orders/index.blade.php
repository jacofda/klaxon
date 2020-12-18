@extends('jacofda::layouts.app')


@include('jacofda::layouts.elements.title', ['title' => __('Orders')])


@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Orders')}}</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-xs table-striped">
                            <thead class="btnone">
                                <tr>
                                    <th style="width:30px;"></th>
                                    <th>{{__('Type')}}</th>
                                    <th>N.</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Comment')}}</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr class="table-{{$order->bg}}" id="row-{{$order->id}}">
                                        <td style="width:30px;"><div style="width:20px;height:20px;background:{{$order->color}}"></div></td>
                                        <td>{{__($order->type)}}</td>
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->created_at->format('d/m/Y H:i')}}</td>
                                        <td>{{$order->comment}}</td>
                                        <td>
                                            @include('jacofda::core.erp.orders.components.progress')
                                        </td>
                                        <td class="pl-2">
                                            @include('jacofda::core.erp.orders.components.actions')
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
<script>
    $('a#menu-erp-ordini').addClass('active');
    $('a#menu-erp-ordini').parent('li').parent('ul.nav-treeview').css('display', 'block');
    $('a#menu-erp-ordini').parent('li').parent('ul').parent('li.has-treeview ').addClass('menu-open');
</script>
@stop
