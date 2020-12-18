@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}expenses">Spese</a></li>
@stop


@include('jacofda::layouts.elements.title', ['title' => 'Modifica nome categorie di spesa'])


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categorie di spesa<br><p class="text-muted mb-0" style="margin-top:-10px;">Doppio click per modificare il nome della categoria</p></h3>

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr id="row-{{$category->id}}" data-model="Category" data-id="{{$category->id}}">
                                    <td class="editable" data-field="nome">{{$category->nome}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
