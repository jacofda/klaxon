<div class="col-md-6">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Nominativo</h3>
        </div>
        <div class="card-body">

            <div class="form-group">
                <label>Ragione Sociale</label>
                {!! Form::text('rag_soc', null, ['class' => 'form-control', 'required']) !!}
                @include('jacofda::components.add-invalid', ['element' => 'rag_soc'])

            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nazione</label>
                        {!! Form::select('nazione', $countries, null, ['class' => 'custom-select', 'id' => 'country']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lingua</label>
                        {!! Form::select('lingua', ['it' => 'it', 'en' => 'en', 'de' => 'de'], null, ['class' => 'custom-select']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Valuta</label>
                        {!! Form::select('valuta', ['EUR' => '€ - EUR', 'USD' => '$ - USD', 'GBP' => '£ - GBP', 'CAD' => '$ - CAD', 'AUD' => '$ - AUD', 'NZD' => '$ - NZD'], null, ['class' => 'custom-select', 'id' => 'country']) !!}
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label>Indirizzo</label>
                        {!!Form::text('indirizzo', null, ['class' => 'form-control', 'placeholder' => 'Indirizzo'])!!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Città</label>
                {!!Form::text('citta', null, ['class' => 'form-control', 'placeholder' => 'Città'])!!}
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label>CAP</label>
                        {!!Form::text('cap', null, ['class' => 'form-control', 'placeholder' => 'CAP'])!!}
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label>Provincia</label>

                        {!!Form::text('provincia', null, [
                            'class' => 'form-control',
                            'placeholder' =>'Provincia o Regione Estera',
                            'id' => 'region'])!!}
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email principale</label>
                        {!!Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Indirizzo Email', 'required', 'autocomplete' => 'off', 'data-type' => 'email'])!!}
                        @include('jacofda::components.add-invalid', ['element' => 'email'])
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>PEC</label>
                        {!!Form::text('pec', null, ['class' => 'form-control', 'placeholder' => 'Email Certificata', 'autocomplete' => 'off', 'data-type' => 'email'])!!}
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email ordini</label>
                        {!!Form::text('email_ordini', null, ['class' => 'form-control', 'placeholder' => 'Indirizzo email per ordini', 'autocomplete' => 'off', 'data-type' => 'email'])!!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email fatturazione</label>
                        {!!Form::text('email_fatture', null, ['class' => 'form-control', 'placeholder' => 'Indirizzo email per fatture', 'autocomplete' => 'off', 'data-type' => 'email'])!!}
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label>Telefono</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="changePrefix"></span>
                    </div>
                    {!!Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Telefono'])!!}
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label>Note</label>
                    {!!Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => 'Note ed eventuali', 'rows' => 3])!!}
                </div>
            </div>

        </div>
    </div>


</div>

<div class="col-md-6">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Fatturazione</h3>
        </div>
        <div class="card-body pb-0">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Pagamento</label>
                        {!!Form::select('pagamento', config('invoice.payment_types') ,null, ['class' => 'form-control '])!!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>P.IVA</label>
                        {!!Form::text('piva', null, ['class' => 'form-control', 'placeholder' => 'Partita iva'])!!}
                        @include('jacofda::components.add-invalid', ['element' => 'piva'])
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CF</label>
                        {!!Form::text('cf', null, ['class' => 'form-control', 'placeholder' => 'Codice fiscale'])!!}
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">Tipologia</h3>
        </div>
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Tipo</label>
                        {!! Form::select('clients[]', $clients , $clientsSelected, [
                            'class' => 'form-control select2bs4 tipologia',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Seleziona una tipologia di cliente',
                            'style' => 'width:100%',
                            'required']) !!}
                    </div>
                </div>

                <div class="col-12 d-none" id="tipoClientSelect">
                    <div class="form-group">
                        <label>Tipo Cliente</label>
                        {!!Form::select('sector_id', $sectors, null, ['class' => 'form-control add-select-tipo'])!!}
                        <p class="text-muted"><small>Scrivi per creare una nuova categoria</small></p>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label>Fornitore</label>
                        {!!Form::select('fornitore',[0 => 'No', 1 => 'Sì'] , null, ['class' => 'custom-select'])!!}
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Partner</label>
                        {!!Form::select('partner',[0 => 'No', 1 => 'Sì'] , null, ['class' => 'custom-select'])!!}
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Attivo</label>
                        {!!Form::select('attivo',[0 => 'No', 1 => 'Sì'] , null, ['class' => 'custom-select'])!!}
                    </div>
                </div>

                <div class="col-12 d-none" id="parentSelect">
                    <div class="form-group">
                        <label>Azienda Madre</label>
                        {!!Form::select('parent_id',$referenti, null, ['class' => 'select2bs4'])!!}
                    </div>
                </div>



                <div class="col-12 d-none" id="fornitoreSelect">
                    <div class="form-group">
                        <label>Tipo Fornitore</label>
                        {!!Form::select('supplier_id', $suppliers, null, ['class' => 'form-control add-select'])!!}
                    </div>
                </div>


                <div class="col-md-9">
                    <div class="form-group">
                        <label>Pricelist</label>
                        {!!Form::select('pricelist_id', $suppliers, null, ['class' => 'form-control add-select'])!!}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Spedizione</label>
                        {!!Form::select('spedizione', [0 => 'No', 1 => 'Sì'], null, ['class' => 'form-control add-select'])!!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Numero</label>
                        {!!Form::text('numero', null, ['class' => 'form-control', 'placeholder' => 'Numeno unico'])!!}
                    </div>
                </div>

            </div>


        </div>
    </div>


    <div class="card">

        <button type="submit" class="btn btn-block btn-success btn-lg" id="submitForm"><i class="fa fa-save"></i> Salva</button>

    </div>

</div>


@section('scripts')
<script>

    $('.add-select-tipo').select2({tags: true, placeholder: 'Associa una tipologia cliente'});

    $('select[name="pagamento"]').select2({placeholder: 'Modalità di pagamento'})

    function prefix()
    {
        $.post("{{url('api/countries')}}", {
            _token: $('input[name="_token"]').val(),
            iso: $('select#country').find(':selected').val()
        }).done(function(data){
            if(data !== null)
            {
                $('span#changePrefix').text('+'+data);
            }
        });
    }

    prefix();

    $('select#country').on('change', function(){
        prefix();
    });

    let fornitore = $('select[name="fornitore"]').val();
    isFornitore(fornitore)
    function isFornitore(val)
    {
        if(val > 0)
        {
            $('div#fornitoreSelect').removeClass('d-none');
        }
        else
        {
            $('div#fornitoreSelect').addClass('d-none');
        }
    }

    $('select[name="fornitore"]').on('change', function(e){
        isFornitore($(this).val());
    });


    let selection = $('select.tipologia').select2("data");
    isReferente(selection);

    function isReferente(selection)
    {
        selection = $('select.tipologia').select2("data");
        let checkIsReferente = 0;
        let checkIsClient = 0;
        $.each(selection, function(i,v){
            if(v.text == 'Referente')
            {
                checkIsReferente++;
            }
            if(v.text == 'Client')
            {
                checkIsClient++;
            }
        });
        if(checkIsReferente > 0)
        {
            $('div#parentSelect').removeClass('d-none');
        }
        else
        {
            $('div#parentSelect').addClass('d-none');
        }

        if(checkIsClient > 0)
        {
            $('div#tipoClientSelect').removeClass('d-none');
        }
        else
        {
            $('div#tipoClientSelect').addClass('d-none');
        }

    }

    $('select.tipologia').on('change', function(e){
        let selection = $(this).select2("data");
        isReferente(selection);
    });

    $('input[name="piva"]').on('focusout', function(){
        $('input[name="cf"]').val($(this).val());
    });


    @if(request()->has('q'))

        let field = "{{request()->get('q')}}";
        $('input[name="'+field+'"]').addClass('is-invalid');

        new Noty({
            text: "Compila i campi obbligatori prima di inviare la fattura",
            type: 'error',
            theme: 'bootstrap-v4',
            timeout: 2500,
            layout: 'topRight'
        }).show();

    @endif

</script>
@stop
