@extends('jacofda::layouts.app')


@include('jacofda::layouts.elements.title', ['title' => 'DDT'])


@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DDT</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bddted table-xs table-striped">
                            <thead class="btnone">
                                <tr>
                                    <th>{{__('Company')}}</th>
                                    <th>N.</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Reference')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ddts as $ddt)
                                    <tr id="row-{{$ddt->id}}">
                                        <td>{{$ddt->company->rag_soc}}</td>
                                        <td>{{$ddt->id}}</td>
                                        <td>{{$ddt->created_at->format('d/m/Y H:i')}}</td>
                                        <td>{{$ddt->riferimento}}</td>
                                        <td class="pl-2">
                                            <a href="{{route('erp.ddt.pdf', $ddt->id)}}" class="btn btn-primary btn-icon btn-sm"><i class="fa fa-file-pdf"></i></a>
                                            <a href="{{route('erp.ddt.edit', $ddt->id)}}" class="btn btn-warning btn-icon btn-sm"><i class="fa fa-edit"></i></a>
                                            {!! Form::open(['method' => 'delete', 'url' => route('erp.ddt.delete', $ddt->id), 'id' => "form-".$ddt->id, 'style'=>'display:inline']) !!}
                                                <button type="submit" id="{{$ddt->id}}" class="btn btn-danger btn-icon btn-sm delete"><i class="fa fa-trash"></i></button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
<script>
    $('a#menu-erp-ddt').addClass('active');
</script>
@stop
