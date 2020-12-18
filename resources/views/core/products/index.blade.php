@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => __('Products') . ' ' . $products->total()])



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary-light">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ta">
                                    <input style="width:100%" id="autoComplete" type="text" tabindex="1">@if(request()->has('id'))<a title="reset" href="{{url('products')}}" class="btn btn-danger reset"><i class="fas fa-times"></i></a>@endif
                            		<div class="selection"></div>
                                </div>
                            </div>
                            <div class="col-6 text-right">

                                <div class="card-tools">
                                    <div class="btn-group" role="group">

                                        <div class="form-group mr-3 mb-0 mt-1">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1" @if(request()->input()) checked @endif>
                                                <label class="custom-control-label" for="customSwitch1">{{__('Advanced Search')}}</label>
                                            </div>
                                        </div>
                                        @can('products.write')
                                            <a class="btn btn-primary btn-sm" href="{{url('products/create')}}"><i class="fas fa-plus"></i> {{__('Create')}} {{__('Product')}}</a>
                                        @endcan


                                    </div>
                                </div>
                            </div>
                        </div>


                </div>
                <div class="card-body">

                    {!! Form::open(['url' => url('products'), 'method' => 'get', 'id' => 'formFilter']) !!}
                        <div class="row @if(!request()->input()) d-none @endif" id="advancedSearchBox">


                                <div class="col-12 col-sm-2 col-xl-1">
                                    <div class="form-group">
                                        <a href="{{route('products.index')}}" class="btn btn-danger" id="refresh"><i class="fa fa-redo"></i> Reset</a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="custom-select" name="group_id">
                                            <option></option>
                                            @foreach(Jacofda\Klaxon\Models\Erp\Group::pluck('nome', 'id') as $key => $nome)
                                                @if(request('group_id') == $key)
                                                    <option selected="selected" value="{{$key}}">{{$nome}}</option>
                                                @else
                                                    <option value="{{$key}}">{{$nome}}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="custom-select" name="acquistabile">
                                            <option></option>
                                            <option value="1" @if(request('acquistabile') == '1') selected @endif>{{__('Component')}}</option>
                                            <option value="0" @if(request('acquistabile') == '0') selected @endif>{{__('End Products')}}</option>
                                        </select>
                                    </div>
                                </div>

                        </div>
                    {{Form::close()}}
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-bordered table-striped table-php">
                            <thead>
                                <tr>
                                    <th>{{__('Name')}}</th>
                                    <th data-field="codice" data-order="asc">{{__('Code')}} <i class="fas fa-sort"></i></th>
                                    @can('products.write')
                                        <th></th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr id="row-{{$product->id}}">
                                        <td>
                                            <a href="{{route('products.show', $product->id)}}">{{$product->name}}</a>
                                        </td>
                                        <td>
                                            {{$product->codice}}
                                        </td>
                                        @can('products.write')
                                            <td class="pl-2">
                                                {!! Form::open(['method' => 'delete', 'url' => $product->url, 'id' => "form-".$product->id]) !!}
                                                    <a href="{{$product->url}}/edit" class="btn btn-warning btn-icon btn-sm"><i class="fa fa-edit"></i></a>
                                                    <a href="{{$product->url}}/media" title="aggiungi media" class="btn btn-info btn-icon btn-sm"><i class="fa fa-image"></i></a>
                                                    @can('products.delete')
                                                        <button type="submit" id="{{$product->id}}" class="btn btn-danger btn-icon btn-sm delete"><i class="fa fa-trash"></i></button>
                                                    @endcan
                                                    <a href="#" class="btn btn-info btn-icon btn-sm">QC</a>
                                                 {!! Form::close() !!}
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
                <div class="card-footer text-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
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

$('select[name="group_id"]').select2({placeholder: {{__('Group')}}});
$('select[name="acquistabile"]').select2({placeholder: "{{__('Type')}}"});

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


<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>

<script>

    const autoCompletejs = new autoComplete({
    data: {
        src: async () => {
            document.querySelector("#autoComplete").setAttribute("placeholder", "Loading...");
            const source = await fetch(
                "{{route('api.ta.products')}}"
            );
            const data = await source.json();
            document.querySelector("#autoComplete").setAttribute("placeholder", "{{__('Search') . ' ' . __('Products')}}");
            return data;
        },
        key: ["name"],
        cache: false
    },
    sort: (a, b) => {
        if (a.match < b.match) return -1;
        if (a.match > b.match) return 1;
        return 0;
    },
    placeHolder: "{{__('Search') . ' ' . __('Products')}}",
    selector: "#autoComplete",
    threshold: 2,
    debounce: 0,
    searchEngine: "strict",
    highlight: true,
    maxResults: 15,
    resultsList: {
        render: true,
        container: (source) => {
            source.setAttribute("id", "autoComplete_list");
        },
        destination: document.querySelector("#autoComplete"),
        position: "afterend",
        element: "ul"
    },
    resultItem: {
        content: (data, source) => {
            source.innerHTML = data.match;
        },
        element: "li"
    },
    noResults: () => {
        const result = document.createElement("li");
        result.setAttribute("class", "no_result");
        result.setAttribute("tabindex", "1");
        result.innerHTML = "No Results";
        document.querySelector("#autoComplete_list").appendChild(result);
    },
    onSelection: (feedback) => {
        const selection = feedback.selection.value.name;
        document.querySelector("#autoComplete").value = "";
        document.querySelector("#autoComplete").setAttribute("placeholder", selection);
        console.log(feedback);
        window.location.href = "{{url('products?id=')}}"+feedback.selection.value.id;
    }
    });

</script>

@stop
