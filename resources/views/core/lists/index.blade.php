@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}contacts">Contatti</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Liste'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary-light">
                    <h3 class="card-title">Tutte le liste</h3>

                    @can('lists.write')
                        <div class="card-tools">
                            <a href="{{url('create-list?sort=updated_at|desc')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Crea Lista</a>
                        </div>
                    @endcan

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>N. contatti</th>
                                    <th>Creata</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lists as $list)
                                    <tr id="row-{{$list->id}}" data-model="{{$list->class}}" data-id="{{$list->id}}">
                                        <td class="editable" data-field="nome">{{$list->nome}}</td>
                                        <td>{{$list->count_contacts}}</td>
                                        <td>{{$list->created_at->format('d/m/Y')}}</td>
                                        <td class="text-center">
                                            {!! Form::open(['method' => 'delete', 'url' => $list->url, 'id' => "form-".$list->id]) !!}
                                                <a href="{{$list->url}}" class="btn btn-primary btn-icon btn-sm"><i class="fa fa-eye"></i></a>
                                                @can('lists.delete')
                                                    <button type="submit" id="{{$list->id}}" class="btn btn-danger btn-icon btn-sm delete"><i class="fa fa-trash"></i></button>
                                                @endcan
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center"> Non ha ancora creato alcuna lista, clicca qui per iniziare <br><a class="btn btn-sm btn-primary" href="{{url('contacts')}}">Crea la tua prima lista</a></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
