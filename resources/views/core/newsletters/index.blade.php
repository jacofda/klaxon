@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => 'Newsletters'])


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card pb-5">
                <div class="card-header bg-secondary-light">
                    <h3 class="card-title">Newsletters</h3>

                    <div class="card-tools">
                        <div class="btn-group" role="group">
                            @can('newsletters.write')
                                <div class="btn-group" role="group">
                                    <a class="btn btn-primary btn-sm" href="{{url('newsletters/create')}}">Crea Newsletter</a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="card-body pb-5">
                    <div class="table-responsive pb-5">
                        <table id="table" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Inviata</th>
                                    <th>Liste</th>
                                    <th>Creata</th>
                                    <th>Modificata</th>
                                    <th data-orderable="false"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newsletters as $newsletter)
                                    <tr id="row-{{$newsletter->id}}">
                                        <td>{{$newsletter->nome}}</td>
                                        <td>@if($newsletter->inviata) Sì @else No @endif</td>
                                        <td>
                                            @if($newsletter->lists()->where('list_id', 1)->exists())
                                                Tutti
                                            @else
                                                @foreach($newsletter->lists as $list)
                                                    @if($loop->last)
                                                        {{$list->nome}} ({{$list->count_contacts}})
                                                    @else
                                                        {{$list->nome.' ('.$list->count_contacts.'), '}}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td data-sort="{{$newsletter->created_at->timestamp}}">{{$newsletter->created_at->format('d/m/Y')}}</td>
                                        <td data-sort="{{$newsletter->updated_at->timestamp}}">{{$newsletter->updated_at->format('d/m/Y')}}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @if($newsletter->inviata)
                                                    <a href="{{$newsletter->url}}/reports" class="btn-sm btn btn-default"><i class="fa fa-eye"></i> Report</a>
                                                @else

                                                    <button id="actions" type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" data-display="static">
                                                        Azioni
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" >
                                                        @if($newsletter->template_id)
                                                            <a href="{{$newsletter->template->url}}" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Anteprima</a>
                                                            @can('newsletters.write')
                                                                <a href="{{$newsletter->url}}/send-test" class="dropdown-item btn-modal" data-toggle="modal" data-target="#modal" data-save="Invia"><i class="fa fa-eye"></i> Invia test email</a>
                                                            @endcan
                                                        @endif
                                                        @can('newsletters.write')
                                                            <a href="{{$newsletter->url}}/edit" class="dropdown-item"><i class="fa fa-edit"></i> Modifica</a>
                                                        @endcan
                                                        @can('newsletters.delete')
                                                            {!! Form::open(['method' => 'delete', 'url' => $newsletter->url, 'id' => "form-".$newsletter->id]) !!}
                                                                <button type="submit" id="{{$newsletter->id}}" class="dropdown-item delete"><i class="fa fa-trash"></i> Elimina</button>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                        @can('newsletters.write')
                                                            <div class="dropdown-divider"></div>
                                                            <a href="{{$newsletter->url}}/send" class="dropdown-item btn-modal" data-toggle="modal" data-target="#modal" data-save="Invia Newsletter"><i class="fas fa-paper-plane"></i> Invia Newsletter</a>
                                                        @endcan
                                                    </div>

                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <br><br><br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script>
    $("#table").DataTable(window.tableOptions);
</script>
@stop
