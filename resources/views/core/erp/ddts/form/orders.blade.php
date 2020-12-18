<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title">{{__('Orders')}} / {{('Products')}}</h3>
    </div>
    <div class="card-body">
        @foreach($orders as $order_id)
            @php $order = Jacofda\Klaxon\Models\Erp\Order::find($order_id) @endphp

            <div class="row">
                <div class="card w-100">
                    <div class="card-header">
                        <h5 class="card-title"><b>{{__($order->type)}}</b>: N.{{$order->id}} {{$order->comment}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>{{__('Code')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th style="width:90px;">Qta</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody @if($loop->last) id="latest-table" data-order="{{$order_id}}" @endif>
                                        @foreach($ddt->items()->where('erp_order_id', $order_id)->get() as $item)
                                            <tr>
                                                <td>{{$item->product->codice}}</td>
                                                <td>{{$item->product->name}}</td>
                                                <td style="width:90px;">{{$item->qta}}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if($loop->last)
                        <div class="card-footer p-0">
                            <a href="#" class="btn btn-sm btn-block btn-primary addRow"><i class="fas fa-plus"></i> {{__('Add Row')}}</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
</div>


@push('scripts')
<script>

    let products = {!! json_encode($products) !!};

    $('a.addRow').on('click', function(e){
        e.preventDefault();
        let table = $('#latest-table');

        let select = '<select name="product" class="form-control select2"></select>';
        let qta = '<input class="form-control" name="qta" type="number" value="1" min="1"/>';
        let add = '<button class="btn btn-sm btn-primary addToOrder"><i class="far fa-save"></i></button>'

        let html = '<tr><td>'+select+'</td><td></td><td>'+qta+'</td><td>'+add+'</td></tr>'
        table.append(html);

        $('select.select2').select2({data:products, width:'100%', placeholder:"Select product"});
    });

    $('#latest-table').on('click', 'button.addToOrder', function(e){
        e.preventDefault();
        let url = "{{route('erp.ddt.product.add', $ddt->id)}}";
        let data = {};
        data.order_id = parseInt($('#latest-table').attr('data-order'));
        data.product_id = parseInt($(this).parent('td').parent('tr').find('td select[name="product"]').val());
        data.qta = parseInt($(this).parent('td').parent('tr').find('td input[name="qta"]').val());
        data._token = token;
        //console.log(data);
        axios.post(url, data).then(function (response) {
          if(response.data === 'done')
          {
              window.location.href = "{{request()->url()}}";
          }
        })
        .catch(function (error) {
            console.log(error);
        });
    });

</script>
@endpush
