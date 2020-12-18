<div class="col-md-6">
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">Corpo</h3>
        </div>
        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Prodotto*</label>
                <div class="col-sm-8">
                    {!! Form::select('product_id', $products, null, ['class' => 'form-control select2bs4', 'data-placeholder' => 'Seleziona Prodotto', 'id' => 'products', 'data-fouc', 'style' => 'width:100%']) !!}
                </div>
            </div>
            <input type="hidden" name="codice" class="codice" value="">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Descrizione</label>
                <div class="col-sm-8">
                    {!! Form::textarea('descrizione', null, ['class' => 'form-control desc', 'rows' => 2, 'maxlength' => 999]) !!}
                </div>
            </div>
            @if(isset($invoice))
                @php $exemption_id = $invoice->company->exemption_id; @endphp
            @else
                @php $exemption_id = null; @endphp
            @endif
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Esenzione</label>
                <div class="col-sm-8">
                    {!! Form::select('exemption_id', $exemptions, $exemption_id, ['class' => 'form-control select2bs4', 'data-placeholder' => 'Seleziona Esenzione', 'data-fouc', 'id' => 'esenzione', 'style' => 'width:100%']) !!}
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Quantità</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        {!! Form::text('qta', 1, ['class' => 'form-control input-decimal']) !!}
                        <div class="input-group-append">
                            <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00</span>
                        </div>
                    </div>
                    @include('jacofda::components.add-invalid', ['element' => 'qta'])
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-xl-7">

                        <div class="form-group row">
                            <label class="col-sm-4 col-xl-7 col-form-label">Prezzo*</label>
                            <div class="col-sm-8 col-xl-5">
                                <div class="input-group xl-ml-5">
                                    {!! Form::text('prezzo', null, ['class' => 'form-control input-decimal', 'id' => 'prezzo']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00€</span>
                                    </div>
                                </div>
                                @include('jacofda::components.add-invalid', ['element' => 'prezzo'])
                            </div>
                        </div>
                </div>
                <div class="col-sm-12 col-xl-5">

                        <div class="form-group row">
                            <label class="col-sm-4 col-xl-5 col-form-label">IVA*</label>
                            <div class="col-sm-8 col-xl-7">
                                <div class="input-group">
                                    {!! Form::text('perc_iva', null, ['class' => 'form-control input-decimal', 'id' => 'perc_iva']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00%</span>
                                    </div>
                                </div>
                                @include('jacofda::components.add-invalid', ['element' => 'perc_iva'])
                            </div>
                        </div>

                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Sconto</label>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col relative">
                            <div class="input-group">
                                {!! Form::text('sconto1', null, ['class' => 'form-control input-decimal']) !!}
                                <div class="input-group-append">
                                    <span class="input-group-text input-group-text-sm" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <span class="abs plus">+</span>
                        </div>
                        <div class="col relative">
                            <div class="input-group">
                                {!! Form::text('sconto2', null, ['class' => 'form-control input-decimal']) !!}
                                <div class="input-group-append">
                                    <span class="input-group-text input-group-text-sm" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <span class="abs plus">+</span>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                {!! Form::text('sconto3', null, ['class' => 'form-control input-decimal']) !!}
                                <div class="input-group-append">
                                    <span class="input-group-text input-group-text-sm" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-primary btn-sm btn-block" data-uid="" id="addItem" disabled><i class="fa fa-plus"></i> AGGIUNGI VOCE</button>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{asset('js/invoices.js')}}"></script>
<script>

@isset($invoice)
    @if($invoice->company->exemption_id)
    $("select#esenzione").select2('data', {id: '{{$invoice->company->exemption_id}}', text: 'esenti'});
    @endif
@endisset

let company = null;
company = $('select[name="company_id"]').val();
$('select[name="company_id"]').on('change', function(){
    company = $('select[name="company_id"]').val();
})


$("#products").on('select2:select', function(){

    if($('button#addItem').hasClass('edit'))
    {
        $.get( baseURL+"api/products/"+$(this).find(':selected').val(), function( data ) {
            $('input.codice').val(data.codice);
        });
    }
    else
    {
        $.get( baseURL+"api/products/"+$(this).find(':selected').val(), function( data ) {
            $('input#prezzo').val(data.prezzo);
            $('input#perc_iva').val("22");
            $('input.codice').val(data.codice);
            $('textarea.desc').val(data.descrizione);
            $('button#addItem').prop('disabled', false);
        });
    }

    if(company)
    {
        $.get( baseURL+"api/companies/"+company+'/discount-exemption', function( data ) {
            let c_exemption = data.exemption_id;
            let c_s1 = data.s1;
            let c_s2 = data.s2;
            let c_s3 = data.s3;
            if(c_exemption)
            {
                $('select[name="exemption_id"]').val(c_exemption).trigger('change');
                $('input[name="perc_iva"]').val(0);
            }
            if(c_s1)
            {
                $('input[name="sconto1"]').val(c_s1);
            }
            if(c_s2)
            {
                $('input[name="sconto2"]').val(c_s2);
            }
            if(c_s3)
            {
                $('input[name="sconto3"]').val(c_s3);
            }
        });
    }


});

$("select#esenzione").on('select2:select', function(){
    $.get( baseURL+"api/exemptions/"+$(this).find(':selected').val(), function( iva ) {
        $('input#perc_iva').val(iva);
    });
});


$('button#addItem').on('click', function(e){
    e.preventDefault();

    var prezzo = $('input#prezzo').val();

    if(prezzo == '')
    {
        $('input#prezzo').addClass('is-invalid');
        alertMe('Il campo prezzo è obbligatorio');
        $('input#prezzo').on('focusin', function(){
            $(this).removeClass('is-invalid');
        });
        return false;
    }

    var select = $('#products').select2('data');
    var desc = $('textarea.desc').val();
    var perc_iva = $('input#perc_iva').val();
    var qta = $('input[name="qta"]').val() ? $('input[name="qta"]').val() : '1.00';
    var sconto = findSconto(getSconti());
    var esenzione_id = $('select[name="exemption_id"]').find(":selected").val() == '' ? null : $('select[name="exemption_id"]').find(":selected").val();
    var perc_sconto = getPercSconto(sconto);
    var codice = $('input.codice').val();

console.log(codice,qta);

    if($(this).hasClass('edit'))
    {
        let newItem = new Item(select[0].id, select[0].text, codice, desc, prezzo, perc_iva, qta, sconto, perc_sconto, esenzione_id);
        console.log(newItem)
        items = items.filter(item => item.uid != $(this).attr('data-uid'));
        items.push(newItem);
        addItemToTable(newItem);
        $('a#prodId-'+$(this).attr('data-uid')).trigger('click');
    }
    else
    {
        item = new Item(select[0].id, select[0].text, codice, desc, prezzo, perc_iva, qta, sconto, perc_sconto, esenzione_id);
        items.push(item);
        console.log(item);
        addItemToTable(item);
    }
});


$('table.table.voci').on('click', 'a.removeProdRow', function(e){
    e.preventDefault();
    var uid = $(this).attr('id').replace('prodId-', '');
    $(this).parent('td').parent('tr').remove();
    items = items.filter(item => item.uid != uid);
});

$('table.table.voci').on('click', 'a.editProdRow', function(e){
    e.preventDefault();
    var uid = $(this).attr('id').replace('prodId-', '');
    var i = items.filter(item => item.uid == uid)[0];
    $('input[name="codice"]').val(i.codice);
    console.log(i.codice)
    $('#products').select2().val(i.id).trigger('change');
    // $('#products').trigger('change');
    $('textarea.desc').val(i.descrizione);
    $('input#perc_iva').val(i.perc_iva);
    $('input#qta').val(i.qta);
    $('input#prezzo').val(i.prezzo);

    if(i.exemption_id)
    {
        $('select[name="exemption_id"]').select2().val(i.exemption_id).trigger('change');
    }
    if(i.perc_sconto)
    {
        $('input[name=sconto1]').val(i.perc_sconto);
    }
    let btn = $('button#addItem');
    btn.prop('disabled', false);
    btn.html('<i class="fa fa-plus"></i> MODIFICA VOCE');
    btn.addClass('edit');
    btn.attr('data-uid', uid);
});


$('button#save').on('click', function(e){
    e.preventDefault();
    if(validate())
    {
        $('textarea#itemsToForm').html(JSON.stringify(items));
        $('button[type="submit"]').trigger('click');
    }
    else
    {
       console.log('Validation did not pass');
    }

});



</script>
@endpush
