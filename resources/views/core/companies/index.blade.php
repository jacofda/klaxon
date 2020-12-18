@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => 'Aziende'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary-light">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ta">
                                <input style="width:100%" id="autoComplete" type="text" tabindex="1">@if(request()->has('id'))<a title="reset" href="{{url('companies')}}" class="btn btn-danger reset"><i class="fas fa-times"></i></a>@endif
                        		<div class="selection"></div>
                            </div>
                        </div>
                        <div class="col-6 text-right">

                            <div class="card-tools">

                                <div class="btn-group" role="group">
                                    <div class="form-group mr-3 mb-0 mt-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" @if(request()->input() && !request()->has('id')) checked @endif>
                                            <label class="custom-control-label" for="customSwitch1">Ricerca Avanzata</label>
                                        </div>
                                    </div>

                                    @can('companies.read')

                                        <div class="btn-group" role="group">
                                            <button id="create" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-display="static" aria-expanded="false">
                                                CSV
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" title="esporta aziende da csv" href="{{url('exports/companies/'. str_replace(request()->url(), '',request()->fullUrl()))}}"><i class="fas fa-download"></i> Esporta da csv</a>
                                                @can('companies.write') <a class="dropdown-item" title="importa aziende da csv" href="{{url('imports/companies')}}"><i class="fas fa-upload"></i> Importa da csv</a> @endcan
                                            </div>
                                        </div>
                                        <a class="btn btn-primary" href="{{route('companies.create')}}"><i class="fas fa-plus"></i> Crea Azienda</a>

                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">

                    @include('jacofda::core.companies.components.advanced-search', ['url_action' => 'companies'])

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped table-php">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th data-field="rag_soc" data-order="asc">Ragione Sociale <i class="fas fa-sort"></i></th>
                                    <th>Nazione</th>
                                    <th>Tipo</th>
                                    <th>Fornitore</th>
                                    <th>Tipo Cliente</th>
                                    <th data-field="created_at" data-order="asc">Data Creazione <i class="fas fa-sort"></i></th>
                                    @can('companies.write')
                                        <th data-orderable="false"></th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $company)
                                    <tr id="row-{{$company->id}}">
                                        <td>{{$company->numero}}</td>
                                        <td><a class="defaultColor" href="{{$company->url}}">{{$company->rag_soc}}</a></td>
                                        <td>{{$company->nazione}}</td>
                                        <td>
                                            @foreach($company->clients as $type)
                                                @if($loop->last)
                                                    {{$type->nome}}
                                                @else
                                                    {{$type->nome}},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>@if($company->fornitore) Sì @endif</td>
                                        <td>
                                            @if($company->sector)
                                                {{$company->sector->nome}}
                                            @endif
                                        </td>
                                        <td data-sort="{{$company->created_at->timestamp}}">{{$company->created_at->format('d/m/Y')}}</td>
                                        @can('companies.write')
                                            <td class="pl-2">
                                                {!! Form::open(['method' => 'delete', 'url' => $company->url, 'id' => "form-".$company->id]) !!}
                                                    <a href="{{$company->url}}/edit" class="btn btn-warning btn-icon btn-sm"><i class="fa fa-edit"></i></a>
                                                    <a href="{{url('erp/checklists/'.$company->id.'/'.$company->class)}}" title="edit checklist" class="btn btn-secondary btn-icon btn-sm"><i class="fa fa-tasks"></i></a>
                                                    @can('companies.delete')
                                                        <button type="submit" id="{{$company->id}}" class="btn btn-danger btn-icon btn-sm delete"><i class="fa fa-trash"></i></button>
                                                    @endcan
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
                    <p class="text-left text-muted">{{$companies->count()}} of {{ $companies->total() }} aziende</p>
                    {{ $companies->appends(request()->input())->links() }}
                </div>

            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>

<script>


// document.querySelector("#autoComplete").addEventListener("autoComplete", (event) => {console.log(event);});
const autoCompletejs = new autoComplete({
	data: {
		src: async () => {
			document.querySelector("#autoComplete").setAttribute("placeholder", "Loading...");
			const source = await fetch(
				"{{url('api/ta/companies')}}"
			);
			const data = await source.json();
			document.querySelector("#autoComplete").setAttribute("placeholder", "Cerca Aziende");
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
	placeHolder: "Cerca Aziende",
	selector: "#autoComplete",
	threshold: 2,
	debounce: 0,
	searchEngine: "strict",
	highlight: true,
	maxResults: 5,
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
        window.location.href = "{{url('companies?id=')}}"+feedback.selection.value.id;
	}
});




</script>


@stop
