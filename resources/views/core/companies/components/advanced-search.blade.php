{!! Form::open(['url' => url($url_action), 'method' => 'get', 'id' => 'formFilter']) !!}
@if(request()->input())
    @if(request()->has('id'))
        <div class="row d-none" id="advancedSearchBox">
    @else
        <div class="row" id="advancedSearchBox">
    @endif
@else
    <div class="row d-none" id="advancedSearchBox">
@endif


    @if(request()->input())
        <div style="float: left;width:87px;">
            <div class="form-group">
                <a href="#" class="btn btn-success btn-sm" id="refresh" style="height:36px; line-height:26px;"><i class="fa fa-redo"></i> Reset</a>
            </div>
        </div>
    @endif

    <div class="col-sm-2">
        <div class="form-group">
            <select class="custom-select" name="region">
                <option></option>
                @foreach(Jacofda\Klaxon\Models\Company::uniqueCountries() as $n)
                    @if(request('nation') == $n['nazione'])
                        <option selected>{{$n['nazione']}}</option>
                    @else
                        <option>{{$n['nazione']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
            <select class="custom-select" name="fornitore">
                <option></option>
                <option value="1" @if(request('fornitore') === 1) selected @endif>Sì</option>
                <option value="0" @if(request('fornitore') === 0) selected @endif>No</option>
            </select>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <select class="custom-select" name="tipo">
                <option></option>
                @foreach(Jacofda\Klaxon\Models\Client::all() as $tipo)
                    @if(request('tipo') == $tipo->id)
                        <option selected="selected" value="{{$tipo->id}}">{{$tipo->nome}}</option>
                    @else
                        <option value="{{$tipo->id}}">{{$tipo->nome}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <select class="custom-select" name="sector">
                <option></option>
                @foreach(Jacofda\Klaxon\Models\Sector::pluck('nome', 'id')->toArray() as $id => $nome)
                    @if(request('sector') == $id)
                        <option selected="selected" value="{{$id}}">{{$nome}}</option>
                    @else
                        <option value="{{$id}}">{{$nome}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>




</div>
{!! Form::close() !!}


@push('scripts')
<script>
    $('#customSwitch1').on('change', function(){
        if($(this).prop('checked') === true)
        {
            $('#advancedSearchBox').removeClass('d-none');
        }
        else
        {
            $('#advancedSearchBox').addClass('d-none');
        }
    });

    $('select[name="sector"]').select2({placeholder: 'Tipo Cliente', width:'100%'});
    $('select[name="tipo"]').select2({placeholder: 'Tipo contatto', width:'100%'});
    $('select[name="fornitore"]').select2({placeholder: 'Fornitore', width:'100%'});
    $('select[name="region"]').select2({placeholder: 'Nazione', width:'100%'});

    $('select.custom-select').on('change', function(){
        $('#formFilter').submit();
    });

    $('#refresh').on('click', function(e){
        e.preventDefault();
        let currentUrl = window.location.href;
        let arr = currentUrl.split('?');
        window.location.href = arr[0];
    });


</script>
@endpush
