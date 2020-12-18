@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => __('Works')])



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary-light">
                    <h3 class="card-title">{{__('Works')}}</h3>

                    <div class="card-tools">
                        <div class="btn-group" role="group">

                            <div class="form-group mr-3 mb-0 mt-1">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" @if(request()->input()) checked @endif>
                                    <label class="custom-control-label" for="customSwitch1">{{__('Advanced Search')}}</label>
                                </div>
                            </div>
                            @can('works.write')
                                <a class="btn btn-primary btn-sm" href="{{route('works.create')}}"><i class="fas fa-plus"></i> {{__('Create')}} {{__('Work')}}</a>
                            @endcan

                        </div>
                    </div>

                </div>
                <div class="card-body">

                    {!! Form::open(['url' => route('works.index'), 'method' => 'get', 'id' => 'formFilter']) !!}
                        <div class="row @if(!request()->input()) d-none @endif" id="advancedSearchBox">

                            @if(request()->input())
                                <div class="col-3">
                                    <div class="form-group">
                                        <label style="color:#fff">Reset</label>
                                        <a href="#" class="btn btn-success" id="refresh"><i class="fa fa-redo"></i> Reset</a>
                                    </div>
                                </div>
                                <div class="col-9">
                            @else
                                <div class="col-12">
                            @endif
                                {{-- <div class="form-group">
                                    <label>Categorie</label>
                                    <select class="custom-select" name="category_id">
                                        <option></option>
                                        @foreach($categories as $category)
                                            @if(request('category_id') == $category->id)
                                                <option value="{{$category->id}}" selected>{{$category->nome}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->nome}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="testo da cercare" name="search" value="{{request('search')}}">
                                        <div class="input-group-append" id="button-addon4">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cerca</button>
                                            <a href="{{route('works.index')}}" class="btn btn-success"><i class="fas fa-redo"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    {{Form::close()}}
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('Name')}}</th>
                                    <th>Output</th>
                                    @can('works.write')
                                        <th></th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($works as $work)
                                    <tr id="row-{{$work->id}}">
                                        <td><a href="{{route('works.show', $work->id)}}">{{$work->nome_it}}</a></td>
                                        <td>{{$work->product->codice}} {{$work->product->name}}</td>
                                        @can('works.write')
                                            <td class="pl-2">
                                                {!! Form::open(['method' => 'delete', 'url' => $work->url, 'id' => "form-".$work->id]) !!}
                                                    <a href="{{$work->url}}/edit" class="btn btn-warning btn-icon btn-sm"><i class="fa fa-edit"></i></a>
                                                    <a href="{{$work->url}}/media" title="aggiungi media" class="btn btn-info btn-icon btn-sm"><i class="fa fa-image"></i></a>
                                                    <a href="{{url('erp/checklists/'.$work->id.'/'.$work->class)}}" title="edit checklist" class="btn btn-secondary btn-icon btn-sm"><i class="fa fa-tasks"></i></a>
                                                     @can('works.delete')
                                                        <button type="submit" id="{{$work->id}}" class="btn btn-danger btn-icon btn-sm delete"><i class="fa fa-trash"></i></button>
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
                    {{ $works->links() }}
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
@stop
