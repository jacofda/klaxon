@if($order->checklists()->exists())

@php
    $checklist_status = $order->check_list_status;
@endphp

    <div class="row">
        <div class="col-12">
            <div class="card @if($checklist_status == 100) card-success collapsed-card @else card-danger @endif">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        Quality Control Ord. {{__('Work')}} N.{{$order->id}} {{$order->created_at->format('d/m/Y')}}
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas @if($checklist_status == 100) fa-plus @else fa-minus @endif"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Entity</th>
                                    <th>Check</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->checklists as $check)
                                    <tr>
                                        <td>
                                            {{__($check->checkable->class)}}
                                            @if($check->checkable->class == 'Company')
                                                {{$check->checkable->rag_soc}}
                                            @else
                                                {{$check->checkable->name}}
                                            @endif
                                        </td>
                                        <td>{{$check->name}}</td>
                                        <td>
                                            <div class="form-group clearfix text-center mt-2 mb-0">
                                                <div class="icheck-success d-inline text-center">
                                                    <input
                                                        type="checkbox"
                                                        id="checkboxSuccess{{$check->id}}"
                                                        @if($check->pivot->status)
                                                            checked
                                                        @endif
                                                        data-id="{{$check->id}}"
                                                        >
                                                    <label for="checkboxSuccess{{$check->id}}"></label>
                                                </div>
                                            </div>
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
@endif

@push('scripts')
    <script>
        $('input[type="checkbox"]').on('click', function(){
            let status = $('input[type="checkbox"]').is(':checked');
            let order = parseInt("{{$order->id}}");
            let id = parseInt($(this).attr('data-id'));
            axios.post("{{route('erp.checks.toggle')}}",{
                _token: token,
                id: id,
                status: status,
                order: order
            }).then(function (response) {
                if(response.data)
                {
                    new Noty({
                        text: "Done",
                        type: 'success',
                        theme: 'bootstrap-v4',
                        timeout: 2500,
                        layout: 'topRight'
                    }).show();
                }
                else
                {
                    new Noty({
                        text: "Undone",
                        type: 'error',
                        theme: 'bootstrap-v4',
                        timeout: 2500,
                        layout: 'topRight'
                    }).show();
                }

            })
              .catch(function (error) {
                  console.log(error);
            });
        });
    </script>
@endpush
