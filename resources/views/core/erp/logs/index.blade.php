@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => 'Logs'])


@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Logs</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-danger clearLog"><i class="fa fa-database"></i> Clear</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bloged table-xs table-striped">
                            <thead class="btnone">
                                <tr>
                                    <th>{{__('Code')}}</th>
                                    <th>{{__('Product')}}</th>
                                    <th>{{__('Before')}}</th>
                                    <th>{{__('Later')}}</th>
                                    <th>Qta</th>
                                    <th>{{__('From')}}</th>
                                    <th>{{__('To')}}</th>
                                    <th>{{__('Order')}}</th>
                                    <th>{{__('Date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{$log->product->codice}}</td>
                                        <td>{{$log->product->name}}</td>
                                        <td>{{$log->before}}</td>
                                        <td>{{$log->after}}</td>
                                        <td>{{$log->qta}}</td>
                                        @include('jacofda::core.erp.logs.components.from-to')
                                        @include('jacofda::core.erp.logs.components.order')
                                        <td>{{$log->created_at->format('d/m/Y H:i')}}</td>
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
    $('a.clearLog').on('click', function(e){
        e.preventDefault();

        axios.post("{{route('erp.logs.clear')}}", {
            _token: token,
          })
          .then(function (response) {
              window.location.href = "{{route('erp.logs')}}";
          })
          .catch(function (error) {
              console.log(error);
          });

    });
</script>
@stop
