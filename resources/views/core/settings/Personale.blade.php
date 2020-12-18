@foreach ($setting->fields as $category => $group)
    @foreach ($group as $n => $values)
        @foreach ($values as $key => $value)
            <div class="form-group row">
                <label for="{{$n}}" class="col-sm-3 col-form-label">@lang('forms.'.$category.'.'.$key)</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control"
                    name="personale[{{$category}}][{{$n}}][{{$key}}]"
                    value="{{$value}}">
                </div>
            </div>
        @endforeach
    @endforeach
@endforeach
