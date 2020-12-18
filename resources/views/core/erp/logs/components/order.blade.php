<td>
    @if($log->order->production)
        <a href="{{$log->order->url}}/edit">{{$log->order->name}}</a>
    @else
        <a href="{{$log->order->url}}">{{$log->order->name}}</a>
    @endif
</td>
