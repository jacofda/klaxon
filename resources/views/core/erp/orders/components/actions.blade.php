<a href="{{$order->url}}" class="btn btn-primary btn-icon btn-sm"><i class="fa fa-eye"></i></a>
@can('products.write')
    @if(!$order->production)
        <a href="{{$order->url}}/edit" class="btn btn-warning btn-icon btn-sm"><i class="fa fa-edit"></i></a>
    @endif
@endcan
{!! Form::open(['method' => 'delete', 'url' => route('erp.orders.delete', $order->id), 'id' => "form-".$order->id, 'style'=>'display:inline']) !!}

    @can('products.delete')
        <button type="submit" id="{{$order->id}}" class="btn btn-danger btn-icon btn-sm delete"><i class="fa fa-trash"></i></button>
    @endcan
{!! Form::close() !!}
