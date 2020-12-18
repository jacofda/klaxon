<div class="col-6">
    <div class="table-responsive">
        <table id="table" class="table table-sm table-borderless">
            <thead class="btnone">
                <tr>
                    <th></th>
                    <th>Input</th>
                    <th>Qta</th>
                    @if(!$order->productions()->where('output_id', $output)->first()->work->supplier->is_home)<th>Qta Lav.</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($order->productions()->where('output_id', $output)->get() as $item)
                    @if($item->is_available)
                        <tr>
                    @else
                        <tr class="table-danger">
                    @endif

                        <td class="bg-{{$item->bg}}"></td>
                        <td>
                            {{$item->input->codice}} <b>x {{$item->input_qta}}</b><br>
                            {{$item->input->name}}
                        </td>
                        <td>{{$item->input->qta_magazzino}}</td>
                        @if(!$item->work->supplier->is_home)<td>{{Jacofda\Klaxon\Models\Store::qtaLavoratore($item->input_id, $work->company_id)}}</td>@endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
