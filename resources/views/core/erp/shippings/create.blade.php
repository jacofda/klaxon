@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Orders')])


@section('content')

<div class="row">
    <div class="col-12 col-sm-12">
        {!! Form::open(['url' => route('erp.orders.store.shippings')]) !!}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Create')}} {{__('Shipping')}}</h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>{{__('Comment')}}</label>
                    {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 1]) !!}
                </div>

                <div class="form-group">
                    <label>{{__('Companies')}}</label>

                    <div class="input-group">
                        {!! Form::select('company_id[]', $companies, $selected, ['class' => 'form-control', 'multiple' => true]) !!}
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">Go</span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="table" class="table table-sm table-xs">
                                <thead>
                                    <tr>
                                        <th data-sortable="false"></th>
                                        <th>N.</th>
                                        <th>{{__('Company')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Comment')}}</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-control" name="orders[]" value="{{$order->id}}">
                                            </td>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->assemblies()->first()->company->rag_soc}}</td>
                                            <td data-order="{{$order->created_at->timestamp}}">{{$order->created_at->format('d/m/Y H:i')}}</td>
                                            <td>{{$order->comment}}</td>
                                            <td data-order="{{$order->stato}}">
                                                @include('jacofda::core.erp.orders.components.progress')
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer p-0">
                <button type="submit" class="btn btn-block btn-success">{{__('Create') . ' ' . ('Shipping')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>



</div>

@stop


@section('scripts')
<script>
    $("#table").DataTable(window.tableOptions);

    $('select[name="company_id[]"]').select2({width:'91%', placeholder:"{{__('Select') . ' ' . __('Companies')}}"})
    $('select[name="company_id[]"]').on('change', function(){
        console.log($(this).val().join('-'));
        window.location.href = "{{url('erp/orders/create/shippings')}}?company_id="+$(this).val().join('-');
    });

    $('a.addP').on('click', function(e){
        e.preventDefault();
        let val = $(this).parent('div').siblings('input').val();
        $(this).parent('div').siblings('input').val(parseInt(val)+1);
    });

    $('a.subP').on('click', function(e){
        e.preventDefault();
        let val = $(this).parent('div').siblings('input').val();
        if(parseInt(val)>0)
        {
            $(this).parent('div').siblings('input').val(parseInt(val)-1);
        }
    });

    $('a.addToCart').on('click', function(e){
        e.preventDefault();
        let prodId = $(this).attr('data-prod');
        let code = $('td#prod-code-'+prodId).text();
        let name = $('td#prod-nome-'+prodId).text();
        let qta = $('input#prod-'+prodId).val();
        if(parseInt(qta) > 0)
        {
            let html = '<tr class="row-'+prodId+'"><td>'+code+'</td><td>'+name+'</td><td><input type="number" style="width:70px" class="form-control form-control-sm" name="products['+prodId+']" value="'+qta+'"></td><td><a href="#" class="btn btn-sm btn-danger removeFromCart" data-prod="'+prodId+'"><i class="fas fa-trash"></i></a></td></tr>'
            $('tbody.appendHere').append(html);
            $('#hidden-footer').removeClass('d-none');
            $('tr.row-input-'+prodId).addClass('d-none');
        }
    });

    $('.appendHere').on('click', 'a.removeFromCart', function(e){
        e.preventDefault();
        $('tr.row-'+$(this).attr('data-prod')).remove();
    });

    $('.submitForm').on('click', function(e){
        e.preventDefault();
        $('input[name="comment"]').val($('textarea[name="comment"]').val());
        $('form#pFrom').submit();
    });

</script>
@stop
