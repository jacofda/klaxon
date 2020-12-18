@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => 'Magazzino '.$products->total()])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header bg-secondary-light">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group ta">
                                <input style="width:100%" id="autoComplete" type="text" tabindex="1">@if(request()->has('id'))<a title="reset" href="{{url('stores')}}" class="btn btn-danger reset"><i class="fas fa-times"></i></a>@endif
                                <div class="selection"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <div class="card-tools">
                                <div class="btn-group" role="group">
                                    <div class="form-group mr-3 mb-0 mt-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" @if(request()->input()) checked @endif>
                                            <label class="custom-control-label" for="customSwitch1">Ricerca Avanzata</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-body">


                    {!! Form::open(['url' => url('stores'), 'method' => 'get', 'id' => 'formFilter']) !!}
                        <div class="row @if(!request()->input()) d-none @endif" id="advancedSearchBox">


                                <div class="col-12 col-sm-2 col-xl-1">
                                    <div class="form-group">
                                        <a href="{{route('stores.index')}}" class="btn btn-danger" id="refresh"><i class="fa fa-redo"></i> Reset</a>
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
                                            <option value="1" @if(request('acquistabile') == '1') selected @endif>Componente</option>
                                            <option value="0" @if(request('acquistabile') == '0') selected @endif>Semilavorato</option>
                                        </select>
                                    </div>
                                </div>

                        </div>
                    {{Form::close()}}



                    <div class="table-responsive">
                        <table class="table table-sm table-xs table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Codice</th>
                                    <th>Nome</th>
                                    {{-- <th data-sortable="false">Vers.</th> --}}
                                    <th>Gruppo</th>
                                    <th>Fornitore</th>
                                    <th>Ord.</th>
                                    <th>Pren.</th>
                                    <th>Sped.</th>
                                    <th>Mag.</th>
                                    <th>Ric.</th>
                                    <th>Fin.</th>
                                    <th>Qta Min</th>
                                    <th data-sortable="false"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr id="row-{{$product->id}}">
                                        <td>{{$product->codice}}</td>
                                        <td>{{$product->nome_it}}</td>
                                        {{-- <td>{{$product->versione}}</td> --}}
                                        <td><small>{{$product->group->nome}}</small></td>
                                        <td><small>{{$product->supplier->rag_soc}}</small></td>
                                        <td>{{$product->ordered}}</td>
                                        <td>0</td>
                                        <td>
                                            <div class="input-group" style="width:100px;">
                                                <input type="number" value="{{$product->qta_spedizione}}" class="form-control form-control-sm" />
                                                <div class="input-group-append">
                                                    <a href="#" class="saveQta input-group-text input-group-text bg-success" data-magazzino="{{Jacofda\Klaxon\Models\Erp\Magazzini::Spedizione()}}" data-id="{{$product->id}}"><i class="fas fa-save"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group" style="width:100px;">
                                                <input type="number" value="{{$product->qta_magazzino}}" class="form-control form-control-sm" />
                                                <div class="input-group-append">
                                                    <a href="#" class="saveQta input-group-text input-group-text bg-success" data-magazzino="{{Jacofda\Klaxon\Models\Erp\Magazzini::Magazzino()}}" data-id="{{$product->id}}"><i class="fas fa-save"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group" style="width:100px;">
                                                <input type="number" value="{{$product->qta_ricambi}}" class="form-control form-control-sm" />
                                                <div class="input-group-append">
                                                    <a href="#" class="saveQta input-group-text input-group-text bg-success" data-magazzino="{{Jacofda\Klaxon\Models\Erp\Magazzini::Ricambi()}}" data-id="{{$product->id}}"><i class="fas fa-save"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group" style="width:100px;">
                                                <input type="number" value="{{$product->qta_finiti}}" class="form-control form-control-sm" />
                                                <div class="input-group-append">
                                                    <a href="#" class="saveQta input-group-text input-group-text bg-success" data-magazzino="{{Jacofda\Klaxon\Models\Erp\Magazzini::Finiti()}}" data-id="{{$product->id}}"><i class="fas fa-save"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @include('jacofda::core.stores.components.qta-min')
                                        </td>
                                        <td></td>
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

    $('select[name="group_id"]').select2({placeholder: 'Gruppo'});
    $('select[name="acquistabile"]').select2({placeholder: 'Tipo'});

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


<script>
    // $("#table").DataTable(window.tableOptions);

    $('a.saveQta').on('click', function(e){
        e.preventDefault();
        let qta = parseInt($(this).parent('div').siblings('input').val());
        let product_id = parseInt($(this).attr('data-id'));
        let company_id = parseInt($(this).attr('data-magazzino'));

        console.log(qta, product_id, company_id);

        axios.post("{{route('stores.update')}}", {
            _token: token,
            qta: qta,
            product_id: product_id,
            company_id: company_id
          })
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
              console.log(error);
          });
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>

<script>

    const autoCompletejs = new autoComplete({
    data: {
        src: async () => {
            document.querySelector("#autoComplete").setAttribute("placeholder", "Loading...");
            const source = await fetch(
                "{{route('api.ta.stores')}}"
            );
            const data = await source.json();
            document.querySelector("#autoComplete").setAttribute("placeholder", "Cerca Prodotti");
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
    placeHolder: "Cerca Prodotti",
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
        window.location.href = "{{url('stores?id=')}}"+feedback.selection.value.id;
    }
    });


    $('a#menu-erp-store-klaxon').addClass('active');
    $('a#menu-erp-store-klaxon').parent('li').parent('ul.nav-treeview').css('display', 'block');
    $('a#menu-erp-store-klaxon').parent('li').parent('ul').parent('li.has-treeview ').addClass('menu-open');
</script>
@stop
