@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">Ordini</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Crea Lavorazione'])


@section('content')

<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Crea Lavorazione</h3>
            </div>
            <div class="card-body">
                <label>Commento</label>
                {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 1]) !!}
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h5 class="header-title mb-0">Lavorabili</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-sm table-xs">
                        <thead>
                            <tr>
                                <th>Codice</th>
                                <th>Nome</th>
                                <th>Disp</th>
                                <th data-sortable="false"></th>
                                <th data-sortable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="row-input-{{$product->id}}">
                                    <td id="prod-code-{{$product->id}}">{{$product->codice}}</td>
                                    <td id="prod-nome-{{$product->id}}">{{$product->nome_it}}</td>
                                    <td>{{$product->qta_finiti}}</td>
                                    <td>
                                        <div class="form-group" style="width:100px; margin-top:5px;margin-bottom:5px;">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <a href="#" class="addP input-group-text input-group-text-sm bg-primary"><i class="fas fa-plus"></i></a>
                                                </div>
                                                <input type="number" class="form-control form-control-sm" min="1" value="0" id="prod-{{$product->id}}">
                                                <div class="input-group-append">
                                                    <a href="#" class="subP input-group-text input-group-text-sm bg-danger"><i class="fas fa-minus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success addToCart" data-prod="{{$product->id}}"><i class="fas fa-cart-plus"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        {!! Form::open(['url' => route('erp.orders.store.productions'), 'id' => 'pFrom']) !!}
            <input type="hidden" name="comment" value="">
            <div class="card">
                <div class="card-header">
                    <h5 class="header-title mb-0">Carrello</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Codice</th>
                                    <th>Nome</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="appendHere">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="hidden-footer" class="card-footer p-0 d-none">
                    <button type="submit" class="submitForm btn btn-block btn-success">Vedi</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

</div>

@stop


@section('scripts')
<script>
    $("#table").DataTable(window.tableOptions);

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
