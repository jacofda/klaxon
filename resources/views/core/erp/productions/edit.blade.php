@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('erp.orders.show.productions', $order->id)}}">{{__('Work')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => "Processa N.".$order->id])


@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    Ord. {{__('Work')}} N.{{$order->id}} {{$order->created_at->format('d/m/Y')}}
                </h3>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{route('erp.orders.show.productions', $order->id)}}"><i class="fas fa-arrow-left"></i> {{__('Back')}}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-2">
                        <div class="row h-100">
                          <div class="col-sm-12 h-100 d-table">
                            <div class="d-table-cell align-middle text-center bg-warning px-2">
                                <b>{{__('Work')}}</b><br>
                                {{$items->first()->work->supplier->rag_soc}}
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="col-10">
                        @include('jacofda::core.erp.productions.edit.table')
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <b>{{__('Comment')}}</b>: <small>{{$order->comment}}</small><br>
                <small>{{__('Work')}} qta: {{$order->productions()->first()->output_qta}} {{__('of')}} {{$order->productions()->first()->work->product->name}} {{$order->productions()->first()->work->product->codice}}</small>
            </div>
        </div>
    </div>

</div>

@stop

@section('scripts')
<script>
    $('body').addClass('sidebar-collapse');

    $('a.addP').on('click', function(e){
        e.preventDefault();
        let val = $(this).parent('div').siblings('input').val();
        let id = $(this).parent('div').siblings('input').attr('data-id');
        if(parseInt($(this).parent('div').siblings('input').attr('max')) > parseInt(val))
        {
            $(this).parent('div').siblings('input').val(parseInt(val)+1);
        }
    });

    $('a.subP').on('click', function(e){
        e.preventDefault();
        let val = $(this).parent('div').siblings('input').val();
        let min = parseInt($(this).parent('div').siblings('input').attr('min'));
        if( parseInt(val) > min)
        {
            $(this).parent('div').siblings('input').val(parseInt(val)-1);
        }
    });


    $('a.saveQta').on('click', function(e){
        e.preventDefault();
        let qta_input_sent = parseInt($(this).parent('div').siblings('input').val());
        let id = parseInt($(this).attr('data-id'));
        let qta = parseInt($(this).parent('div').siblings('input').attr('min'));
        let company_id = parseInt(findAvailableMag(id, qta));

        axios.post("{{url('erp/orders/productions')}}/"+id, {
            _token: token,
            input_qta_sent: qta_input_sent,
            company_id: company_id
          })
          .then(function (response) {
            console.log(response);
            if((qta == qta_input_sent) && (qta_input_sent > 0))
            {
                $('tr#row-'+id).removeClass().addClass('table-success');
                $('a#cell-'+id).removeClass('d-none');
                $('#counter-'+id).addClass('d-none');
            }
            else
            {
                $('tr#row-'+id).removeClass().addClass('table-warning');
            }
            // if()
            // let qn = parseInt($('td#mag-'+id).text());
            // $('td#mag-'+id).text(qn-qta_input_sent);
          })
          .catch(function (error) {
              console.log(error);
          });
    });

    function findAvailableMag(id, qta)
    {
        let result = 0;
        if($('tr#row-'+id+' td.text-primary').length > 0)
        {
            $.each($('tr#row-'+id+' td.text-primary'), function(){
                if(parseInt($(this).text()) >= qta )
                {
                    $(this).addClass('text-primary');
                    result = $(this).attr('data-mag');
                }
            });
        }
        else
        {
            result = $('tr#row-'+id+' td#mag-'+id).attr('data-mag');
        }

        return result;
    }

    $('td.clickable').on('click', function(){

        if($(this).attr('data-min') > parseInt($(this).text()))
        {
            return false;
        }

        let id = $(this).parent('tr').attr('id').replace('row-', '');
        let type = 'for';
        if($(this).hasClass('mag'))
        {
            type = 'mag';
        }
        $.each($('tr#row-'+id+' td.clickable'), function(){
            if(!$(this).hasClass(type))
            {
                $(this).removeClass('text-primary');
            }
            else
            {
                $(this).addClass('text-primary');
            }
        });
    });

    $('a.toggleLock').on('click', function(e){
        e.preventDefault();
        console.log('clicked');
        if($(this).find('i').hasClass('fa-unlock'))
        {
            $(this).find('i').removeClass('fa-unlock').addClass('fa-lock');
            $(this).siblings('div').removeClass('d-none');
        }
        else
        {
            $(this).find('i').removeClass('fa-lock').addClass('fa-unlock');
            $(this).siblings('div').addClass('d-none');
        }

    });

</script>
@stop
