@if($product->acquistabile)
    <div class="form-group" style="width:100px; margin-top:5px;margin-bottom:5px;">
        <div class="input-group">
            <div class="input-group-prepend">
                <a href="#" class="addP input-group-text input-group-text-sm bg-primary" data-id="{{$product->id}}"><i class="fas fa-plus"></i></a>
            </div>
            <input type="number" class="form-control form-control-sm" min="1" data-work="{{$work->id}}" data-output="{{$work->product_id}}" data-multiplier="{{$qta_work}}" value="{{$multiplier * $qta_work}}" id="prod-{{$product->id}}">
            <div class="input-group-append">
                <a href="#" class="subP input-group-text input-group-text-sm bg-danger" data-id="{{$product->id}}"><i class="fas fa-minus"></i></a>
            </div>
        </div>
    </div>
@else
    <div class="form-group" style="width:100px; margin-top:5px;margin-bottom:5px;">
        <div class="input-group">
            <div class="input-group-prepend">
                <a href="#" class="addP input-group-text input-group-text-sm bg-primary" data-children="{{$product->children_string}}" data-id="{{$product->id}}"><i class="fas fa-plus"></i></a>
            </div>
            <input type="number" class="form-control form-control-sm" min="1" data-work="{{$work->id}}" data-output="{{$work->product_id}}" data-multiplier="{{$qta_work}}" value="{{$multiplier * $qta_work}}" id="prod-{{$product->id}}">
            <div class="input-group-append">
                <a href="#" class="subP input-group-text input-group-text-sm bg-danger" data-children="{{$product->children_string}}" data-id="{{$product->id}}"><i class="fas fa-minus"></i></a>
            </div>
        </div>
    </div>
@endif
