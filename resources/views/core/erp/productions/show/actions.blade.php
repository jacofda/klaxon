@php

    $available = 1;
    foreach($order->productions()->where('output_id', $output)->get() as $p)
    {
        if(!$p->is_available)
        {
            $available = 0;
        }
    }
    $item = $order->productions()->where('output_id', $output)->first();
@endphp

<div class="col">
    <div class="row h-100">
        <div class="col-sm-12 h-100 d-table">
            <div class="d-table-cell align-middle text-center bg-warning px-2">
                <b>Lavorazione</b><br>
                <a href="{{$work->url}}" target="_BLANK">
                    {{$work->codice}}
                </a><br>
                <small>{{$work->nome_it}}</small>
            </div>
        </div>
    </div>
</div>
<div class="col">
    <div class="row h-100">
        <div class="col-sm-12 h-100 d-table">
            <div class="d-table-cell align-middle text-center px-2">
                @if(($item->status === 0) && $available)
                    <a class="btn btn-success" href="{{route('erp.orders.edit.productions', ['order_id' => $order->id, 'output_id' => $item->output_id])}}">Processa</a>
                @elseif($item->status === 1)
                    <a class="btn btn-primary" href="{{route('erp.orders.complete.productions', ['order_id' => $order->id, 'output_id' => $item->output_id])}}">Termina</a>
                @elseif($item->status === 2)
                    <a class="btn btn-secondary" href="#" >Fatto</a>
                @else
                    <a class="btn btn-danger" href="#" >Bloccato</a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="col">
    <div class="row h-100">
        <div class="col-sm-12 h-100 d-table">
            <div class="d-table-cell align-middle text-center px-2">
                @if(($item->status === 0) && $available)
                    <span class="text-success">Da iniziare</span>
                @elseif($item->status === 1)
                    <span class="text-primary" href="#">In attesa</span>
                @elseif($item->status === 2)
                    <span class="text-secondary" href="#">Fatto</span>
                @else
                    <span class="text-danger" href="#">Input non disponibili</span>
                @endif
            </div>
        </div>
    </div>
</div>
