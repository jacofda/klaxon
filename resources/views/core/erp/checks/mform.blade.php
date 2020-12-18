@php $checkNull = ''; @endphp
<div class="col-12">
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">
                @if($model->class == 'Company')
                    {{$model->rag_soc}}
                @else
                    {{$model->codice}}<br>
                    {{$model->name}}
                @endif
            </h3>
        </div>
        <div class="card-body qc">

            @if(isset($model))
                @if($model->checks()->exists())
                    @foreach($model->checks as $check)
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>
                                    </div>
                                    {!! Form::text('checks[]', $check->name, ['class' => 'form-control', 'placeholder' => 'Write check here ... ']) !!}
                                    <div class="input-group-append">
                                        @if($loop->last)
                                            <a href="#" class="btn btn-primary add" title="aggiungi"><i class="fas fa-plus"></i></a>
                                        @endif
                                    </div>
                                    <input type="hidden" name="check_ids[]" value="{{$check->id}}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>
                                </div>
                                {!! Form::text('checks[]', $checkNull, ['class' => 'form-control', 'placeholder' => 'Write check here ... ']) !!}
                                <div class="input-group-append" style="width:100px">
                                    <a href="#" class="btn btn-primary add" title="aggiungi"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="col-12">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>
                            </div>
                            {!! Form::text('checks[]', $checkNull, ['class' => 'form-control', 'placeholder' => 'Write check here ... ']) !!}
                            <div class="input-group-append" style="width:100px">
                                <a href="#" class="btn btn-primary add" title="aggiungi"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <div class="card-footer p-0">
            <button class="btn btn-block btn-success" type="submit">{{__('Save')}}</button>
        </div>
    </div>
</div>

@push('scripts')

<script>

    function randomInteger(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    $('.qc').on('click', 'a.add', function(e){
        e.preventDefault();
        let html ='<div class="col-12">'+
                        '<div class="form-group">'+
                            '<div class="input-group">'+
                                '<div class="input-group-prepend">'+
                                    '<a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>'+
                                '</div>'+
                                '<input class="form-control" id="regex" name="checks[]" placeholder="write check here ...">'+
                                '<div class="input-group-append">'+
                                    '<a href="#" class="btn btn-primary add" title="aggiungi"><i class="fas fa-plus"></i></a>' +
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
        let newInput = "input-"+randomInteger(1, 1000);
        let newHtml = html.replace("regex", newInput);
        $('.qc').append(newHtml);
    });

    $('.qc').on('click', 'a.remove', function(e){
        e.preventDefault();
        let check_id = $(this).parent('div').siblings('input[type="hidden"]').val();
        if(check_id)
        {
            axios.post("{{route('erp.checks.remove')}}", {
                _token: token,
                id: check_id,
              })
              .then(function (response) {
                  if(response.data == 'done')
                  {
                      new Noty({
                          text: "Quality Control Deleted",
                          type: 'success',
                          theme: 'bootstrap-v4',
                          timeout: 2500,
                          layout: 'topRight'
                      }).show();
                  }
                  else
                  {
                      console.log(response);
                  }
              })
              .catch(function (error) {
                  console.log(error);
              });
        }
        $(this).parent('div').parent('div').parent('div').remove();
    });
</script>

@endpush
