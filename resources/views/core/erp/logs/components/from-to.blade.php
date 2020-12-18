<td>
    @if(is_null($log->from))
        @if($log->order->purchase)
            Acquisto
        @elseif($log->order->production)
            Lavorazione
        @endif
    @else
        {{ $log->from->rag_soc }}
    @endif

</td>
<td>
    @if(is_null($log->to))
        @if($log->order->purchase)
            Acquisto
        @elseif($log->order->production)
            Lavorazione
        @endif
    @else
        {{ $log->to->rag_soc }}
    @endif
</td>
