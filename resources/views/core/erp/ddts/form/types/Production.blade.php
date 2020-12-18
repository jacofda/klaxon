<div class="row">
    <div class="card w-100">
        <div class="card-header">
            <h5 class="card-title"><b>{{__('Production')}}</b>: N.{{$order->id}} {{$order->comment}}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{__('Code')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>Qta</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->productions as $item)
                                <tr>
                                    <td>{{$item->product->codice}}</td>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->qta}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </wdiv>
        </div>
    </div>
</div>
