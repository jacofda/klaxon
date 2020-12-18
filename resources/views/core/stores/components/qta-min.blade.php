@php
    $pr = $product->qta_ricambi;
    $pm = $product->qta_magazzino;
    $mqr = $product->qta_min;
    $mqm = $product->qta_min_magazzino;

    $color_ric = 'success';
    if($pr == $mqr)
    {
        $color_ric = 'warning';
    }
    elseif($pr < $mqr)
    {
        $color_ric = 'danger';
    }


    $color_mag = 'success';
    if($pm == $mqm)
    {
        $color_mag = 'warning';
    }
    elseif($pm < $mqm)
    {
        $color_mag = 'danger';
    }



@endphp

<span class="badge bg-{{$color_ric}}"> {{$product->qta_ricambi}}/{{$product->qta_min}} </span>
<span class="badge bg-{{$color_mag}}"> {{$product->qta_magazzino}}/{{$product->qta_min_magazzino}} </span>
