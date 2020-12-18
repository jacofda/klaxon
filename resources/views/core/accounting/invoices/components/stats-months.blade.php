<div class="row">
    @for($x=1;$x<=12;$x++)

        @php
            $current = $month_stats[date('Y')][$x];
            $last = $month_stats[(date('Y')-1)][$x];
            $perc = 0;
            if($current != 0 && $last != 0)
            {
                $perc = round((1-$current/$last)*100);
                $perc = ($last > $current) ? -abs($perc) : abs($perc);
            }

        @endphp

        <div class="col-3 col-lg-1 ">
            <div class="small-box text-center">
                @lang('dates.ms'.$x)<br>
                @if($current != 0)
                    <small>€ {{number_format($current, 0, ',', '.')}}</small>
                @endif
                @if($current == $last || $current == 0)
                    <small class="text-muted"><i class="fas fa-minus text-sm"></i></small>
                @elseif($current > $last)
                    <small class="text-success"><i class="fas fa-arrow-up text-sm"></i>@if($perc != 0) {{$perc}}% @endif</small>
                @else
                    <small class="text-danger"><i class="fas fa-arrow-down text-sm"></i>@if($perc != 0) {{$perc}}% @endif</small>
                @endif
            </div>
        </div>
    @endfor
</div>
