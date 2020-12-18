<div class="col-md-6">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Intestazione</h3>
        </div>
        <div class="card-body">


            <div class="form-group row">
                <label class="col-sm-4 col-form-label">{{__('Number')}}*</label>
                <div class="col-sm-8">
                    {!! Form::text('numero', null, ['class' => 'form-control']) !!}
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-4 col-form-label">{{__('Date')}}*</label>
                <div class="col-sm-8">
                    <div class="input-group" id="data" data-target-input="nearest">
                        @php
                            if(isset($invoice))
                            {
                                $data = $invoice->data ? $invoice->data->format('d/m/Y') : null;
                            }
                            else
                            {
                                $data = date('d/m/Y');
                            }
                        @endphp
                        {!! Form::text('data', $data, ['class' => 'form-control', 'data-target' => '#data', 'data-toggle' => 'datetimepicker', 'required']) !!}
                       <div class="input-group-append" data-target="#data" data-toggle="datetimepicker">
                           <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                       </div>
                   </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">{{__('Company')}}*</label>
                <div class="col-sm-8">
                    {!! Form::select('company_id',$companies,
                        null, ['class' => 'form-control select2bs4', 'data-placeholder' => 'Seleziona Azienda', 'required', 'data-fouc']) !!}
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">{{__('Reference')}}</label>
                <div class="col-sm-8">
                    {!! Form::text('riferimento', null, ['class' => 'form-control']) !!}
                </div>
            </div>

        </div>
    </div>
</div>
<div class="col-md-6">
    @include('jacofda::core.accounting.invoices.form-components.extra-ddt')
</div>
<div class="col-md-12">
    @include('jacofda::core.erp.ddts.form.orders')
</div>

<div class="col-md-12">
    <div class="card p-0">
        <button type="submit" class="btn btn-block btn-success">Salva</button>
    </div>
</div>

@push('scripts')
<script>

$('#extra-ddt').css({display:'block'});

$('input[name="numero"]').on('focusout', function(){
    let tipo = "D";
    let anno = "{{$ddt->data->format('Y')}}";

    data = {
        _token: "{{csrf_token()}}",
        type: tipo,
        year: anno,
        number: $(this).val()
    };

    $.post("{{url('api/invoices/check')}}", data).done(function( data ) {
        if( parseInt(data) == 1)
        {
            new Noty({
                text: "Numero già usato da un'altra fattura! Cambiato con un valore valido",
                type: 'error',
                theme: 'bootstrap-v4',
                timeout: 2500,
                layout: 'topRight'
            }).show();

            retriveNumero(tipo, anno)

            new Noty({
                text: "Cambiato con un valore valido",
                type: 'success',
                theme: 'bootstrap-v4',
                timeout: 2500,
                layout: 'topRight'
            }).show();

        }
    });

});

$('.select-minimal').select2({minimumResultsForSearch: -1, width:'100%'});
$('#data').datetimepicker({ format: 'DD/MM/YYYY' });
$('#data_saldo').datetimepicker({ format: 'DD/MM/YYYY' });


//on change of anno retrive new numero
$('select[name="anno"]').on('change', function(){
    var anno = $(this).find(':selected').val() ? $(this).find(':selected').val() : moment().format('YYYY');
    var tipo = $('select[name="tipo"]').find(':selected').val() ? $('select[name="tipo"]').find(':selected').val() : "F";
    retriveNumero(tipo, anno);
});

const retriveNumero = (tipo, anno) => {

    var url = "{{config('app.url')}}"+"api/invoices/"+tipo+"?anno="+anno;
    var str = window.location.href;
    var arr = str.split('/');
    var id = 0;
    arr.forEach(function(e){
        if(Number.isInteger(parseInt(e)))
        {
            id = e;
        }
    });

    if(id != 0)
    {
        url +="&id="+id;
    }

    $.get( url, function( data ) {
        $('input[name="numero"]').val(data);
        $('select[name="anno"]').val(anno);
    });
};


</script>
@endpush
