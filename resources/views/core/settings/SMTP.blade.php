@php
    $c = 1;
@endphp
@foreach ($setting->fields as $smtp => $values)
    @foreach ($values as $key => $value)
        <div class="form-group row">
            <label for="{{$key}}" class="col-sm-3 col-form-label">
                #{{$c}} @lang('forms.'.$key)
            </label>
            <div class="col-sm-9">
                @if($key === 'MAIL_ENCRYPTION')

                    <select class="custom-select" name="smtp[{{$smtp}}][{{$key}}]">
                        <option value="" @if(is_null($value)) selected="selected" @endif>non-protetto</option>
                        <option value="SSL" @if($value == 'SSL') selected="selected" @endif>SSL</option>
                        <option value="TSL" @if($value == 'TSL') selected="selected" @endif>TSL</option>
                    </select>
                @elseif($key == 'MAIL_DRIVER')
                    <select class="custom-select" name="smtp[{{$smtp}}][{{$key}}]">
                        <option value="smtp" @if($value == 'smtp') selected="selected" @endif>smtp</option>
                        <option value="localhost" @if($value == 'localhost') selected="selected" @endif>localhost</option>
                    </select>
                @else
                    <input type="text" class="form-control" name="smtp[{{$smtp}}][{{$key}}]" value="{{$value}}">
                @endif
            </div>
        </div>
    @endforeach
    <div class="col-12" style="background:#000;min-height:2px; margin-bottom:20px;"></div>
    @php
        $c++;
    @endphp
@endforeach
