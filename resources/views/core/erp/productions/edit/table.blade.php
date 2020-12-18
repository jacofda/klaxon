@php
    $work = $items->first()->work;
@endphp

<div class="table-responsive">
    <table id="table" class="table table-sm table-borderless">
        <thead class="btnone">
            <tr>
                <th>Input</th>
                <th>Qta Mag</th>
                @if(!$work->supplier->is_home)<th>Qta Mag. Lavoratore</th>@endif
                <th>Qta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)

                @php
                    $dnone = true;
                    if($item->stato == 100)
                    {
                        $dnone = false;
                    }
                @endphp

                <tr class="table-{{$item->bg}}" id="row-{{$item->id}}">
                    <td>
                        {{$item->input->codice}} <b>x {{$item->input_qta}}</b><br>
                        {{$item->input->name}}
                    </td>
                    <td id="mag-{{$item->id}}" class="clickable mag text-center" data-mag="{{Jacofda\Klaxon\Models\Erp\Magazzini::Magazzino()}}" data-min="{{$item->input_qta}}">{{$item->input->qta_magazzino}}</td>
                    @if(!$work->supplier->is_home)<td class="clickable for text-center" data-mag="{{$item->input_company_id}}" data-min="{{$item->input_qta}}">{{Jacofda\Klaxon\Models\Store::qtaLavoratore($item->input_id, $work->company_id)}}</td>@endif
                    <td>
                        <div style="display:inline-flex;margin-top:5px;margin-bottom:5px;">
                        @if($dnone)

                            <div class="form-group" style="width:250px; margin-top:5px;margin-bottom:5px;" id="counter-{{$item->id}}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <a href="#" class="addP input-group-text input-group-text bg-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                    <input type="number" class="form-control form-control" min="{{$item->input_qta}}" max="{{max($item->input->qta_magazzino, $item->qta_fornitore)}}" value="{{$item->input_qta}}" data-id="{{$item->id}}" id="prod-{{$item->product_id}}">
                                    <div class="input-group-append">
                                        <a href="#" class="subP input-group-text input-group-text bg-danger"><i class="fas fa-minus"></i></a>
                                    </div>

                                    <div class="input-group-append">
                                        <a href="#" class="saveQta input-group-text input-group-text bg-success" data-id="{{$item->id}}"><i class="fas fa-save"></i></a>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-secondary toggleLock d-none" id="cell-{{$item->id}}"><i class="fas fa-unlock"></i></a>

                        @else

                            <div class="form-group d-none" style="width:250px;margin-bottom:0;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <a href="#" class="addP input-group-text input-group-text bg-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                    <input type="number" class="form-control form-control" min="{{$item->input_qta}}" max="{{max($item->input->qta_magazzino, $item->qta_fornitore)}}" value="{{$item->input_qta}}" data-id="{{$item->id}}" id="prod-{{$item->product_id}}">
                                    <div class="input-group-append">
                                        <a href="#" class="subP input-group-text input-group-text bg-danger"><i class="fas fa-minus"></i></a>
                                    </div>

                                    <div class="input-group-append">
                                        <a href="#" class="saveQta input-group-text input-group-text bg-success" data-id="{{$item->id}}"><i class="fas fa-save"></i></a>
                                    </div>
                                </div>
                            </div>

                            <a href="#" class="btn btn-secondary toggleLock"><i class="fas fa-unlock"></i></a>

                        @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
