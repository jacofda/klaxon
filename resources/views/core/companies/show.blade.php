@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}companies">Aziende</a></li>
@stop

@section('css')
<style>
.expandable tr:hover{cursor:pointer;}
</style>
@stop

@include('jacofda::layouts.elements.title', ['title' => $company->rag_soc])

@section('content')

    <div class="row">

        <div class="col-md-3">

            <div class="card card-info card-outline">
                <div class="card-body box-profile">
                    <div class="text-center pb-3">
                        {!!$company->avatar!!}
                        <h3 class="profile-username text-center">{{$company->rag_soc}}</h3>

                        @if($company->clients)
                            <p class="text-muted text-center mb-0">
                                @foreach($company->clients as $type)
                                    @if($loop->last)
                                        {{$type->nome}}
                                    @else
                                        {{$type->nome}},
                                    @endif
                                @endforeach
                            </p>
                        @endif

                        @if($company->partner)
                            <p class="text-success mb-0">Partner</p>
                        @endif
                        @if($company->fornitore)
                            <p class="text-danger mb-0">Fornitore</p>
                        @endif

                    </div>
                    <ul class="list-group list-group-unbordered mb-3">
                        @if($company->contacts()->exists())
                            @foreach($company->contacts as $contact)
                                <li class="list-group-item text-center" style="line-height:1rem;">
                                    <a href="{{$contact->url}}" >
                                        {{$contact->fullname}}</b>
                                        <code style="color:#222">{{$contact->email}}</code>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    @can('companies.write')
                        <a href="{{$company->url}}/edit" class="btn btn-sm btn-warning btn-block"><b> <i class="fa fa-edit"></i> Modifica</b></a>
                    @endcan
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Dettagli</h3>
                </div>
                <div class="card-body psmb">
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Indirizzo</strong>
                    <p class="text-muted">{{$company->indirizzo}} <br>
                         {{$company->cap}}, {{$company->citta}} ({{$company->sigla_provincia}}) {{$company->nazione}}
                    </p>
                    <hr>
                    <strong><i class="fas fa-euro-sign mr-1"></i> Fatturazione</strong>
                    @if($company->pec)<p class="text-muted"><b>PEC:</b> {{$company->pec}}</p>@endif
                    @if($company->piva)<p class="text-muted"><b>P.IVA:</b> {{$company->piva}}</p>@endif
                    @if($company->cf)<p class="text-muted"><b>CF:</b> {{$company->cf}}</p>@endif
                    @if($company->sdi)<p class="text-muted"><b>SDI:</b> {{$company->sdi}}</p>@endif
                    <hr>
                    <strong><i class="fas fa-at mr-1"></i> Contatti</strong>
                    @if($company->telefono)<p class="text-muted"><b>Tel:</b> {{$company->telefono}}</p>@endif
                    @if($company->email)<p class="text-muted"><b>Email:</b> <small>{{$company->email}}</small></p>@endif
                    @if($company->email_ordini)<p class="text-muted"><b>Email Ord.:</b> <small>{{$company->email_ordini}}</small></p>@endif
                    @if($company->email_fatture)<p class="text-muted"><b>Email Fatt.:</b> <small>{{$company->email_fatture}}</small></p>@endif
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Info</a></li>
                        <li class="nav-item"><a class="nav-link" href="#eventi" data-toggle="tab">Eventi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contatti" data-toggle="tab">Contatti</a></li>
                        @if($company->invoices()->exists())
                            @can('invoices.read')
                                <li class="nav-item"><a class="nav-link" href="#fatture" data-toggle="tab">Fatture</a></li>
                            @endcan
                            @can('products.read')
                                <li class="nav-item"><a class="nav-link" href="#prodotti" data-toggle="tab">Prodotti Venduti</a></li>
                            @endcan
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="info">
                            @include('jacofda::core.companies.components.info')
                        </div>
                        <div class="tab-pane" id="contatti">
                            @can('products.read')
                                @include('jacofda::core.companies.components.contacts')
                            @endcan
                        </div>
                        @if($company->events()->exists())
                            <div class="tab-pane" id="eventi">
                                @include('jacofda::core.companies.components.events')
                            </div>
                        @endif
                        <div class="tab-pane" id="fatture">
                            @can('invoices.read')
                                @include('jacofda::core.companies.components.invoices')
                            @endcan
                        </div>
                        <div class="tab-pane" id="prodotti">
                            @can('products.read')
                                @include('jacofda::core.companies.components.products')
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@stop

@section('scripts')
<script>
    $('.nav-pills li a').on('click', function(){
        console.log($(this).attr('href'));
    });
    let currentUrl = window.location.href;
    if(currentUrl.includes('#'))
    {
        let arr = currentUrl.split('#');
        $('a[href="#'+arr[1]+'"]').click();
    }

</script>
@stop
