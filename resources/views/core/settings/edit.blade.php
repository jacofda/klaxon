@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}settings">Settings</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Modifica Settings'])


@section('content')

    {!! Form::model($setting, ['url' => $setting->url, 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'settingForm', 'files' => true]) !!}
        <div class="row">
            @include('jacofda::components.errors')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="Modello" class="col-sm-3 col-form-label">@lang('forms.model')</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="model"  value="{{$setting->model}}" disabled>
                            </div>
                        </div>


                        @if($setting->model == 'SMTP')
                            @include('jacofda::core.settings.SMTP')
                        @elseif($setting->model == 'Personale')
                            @include('jacofda::core.settings.Personale')
                        @else

                            @foreach ($setting->fields as $key => $value)
                                @if(strpos($key, '_img'))

                                    <div class="form-group row">
                                        <label for="{{$key}}" class="col-sm-3 col-form-label" style="line-height:16px;">@lang('forms.'.$key)</label>
                                        <div class="col-sm-9">

                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="{{$key}}" lang="it" name="{{$key}}">
                                                <label class="custom-file-label" for="{{$key}}" data-browse="Sfoglia">
                                                    @if($value != "")
                                                        {{$value}}
                                                    @else
                                                        Scegli file
                                                    @endif
                                                </label>
                                            </div>

                                            <script>
                                                document.querySelector("#{{$key}}").addEventListener('change',function(e){
                                                    var fileName = document.getElementById("{{$key}}").files[0].name;
                                                    var nextSibling = e.target.nextElementSibling
                                                    nextSibling.innerText = fileName
                                                });
                                            </script>

                                        </div>
                                    </div>

                                @else

                                    @if(strpos($key, 'regime') !== false)

                                        <div class="form-group row">
                                            <label for="{{$key}}" class="col-sm-3 col-form-label">@lang('forms.'.$key)</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('regime', config('invoice.regime'), $value, ['class' => 'custom-select']) !!}
                                            </div>
                                        </div>

                                    @elseif($key == 'connettore')
                                        <div class="form-group row">
                                            <label for="{{$key}}" class="col-sm-3 col-form-label">@lang('forms.'.$key)</label>
                                            <div class="col-sm-9">
                                                <select class="custom-select" name="{{$key}}">
                                                    <option value="" @if(is_null($value)) selected="selected" @endif></option>
                                                    <option value="Aruba" @if($value == 'Aruba') selected="selected" @endif>Aruba</option>
                                                    <option value="Fattura in Cloud" @if($value == 'Fattura in Cloud') selected="selected" @endif>Fattura in Cloud</option>
                                                </select>
                                            </div>
                                        </div>

                                    @else
                                        <div class="form-group row">
                                            <label for="{{$key}}" class="col-sm-3 col-form-label">@lang('forms.'.$key)</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="{{$key}}" value="{{$value}}">
                                            </div>
                                        </div>
                                    @endif

                                @endif

                            @endforeach

                        @endif

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success" id="submitForm"><i class="fa fa-save"></i> Salva</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

@stop
