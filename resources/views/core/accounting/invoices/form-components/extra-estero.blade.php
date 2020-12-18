<div class="card card-outline card-info" id="extra-estero" style="display:none;">
    <div class="card-header">
        <h3 class="card-title">Extra Bollo Estero</h3>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-sm-12 col-xl-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-xl-8 col-form-label">Importo bollo</label>
                    <div class="col-sm-8 col-xl-4">
                        {!! Form::text('bollo', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-xl-6 col-form-label">Da imputare a</label>
                    <div class="col-sm-8 col-xl-6">
                        {!! Form::select('bollo_a', ["" => "Seleziona", "cliente" => "Cliente", "azienda" => "Azienda"], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@push('scripts')
    <script>

    const extraEsteroFields = (t) => {
        if(t != 'IT')
        {
            $('#extra-estero').css({display: 'block'});
        }
        else
        {
            $('#extra-estero').css('display', 'none');
        }
    }

    $('select[name="company_id"]').on('select2:select', function(){
        $.get(baseURL+"api/companies/"+$(this).find(':selected').val(), function( nation ) {
            extraEsteroFields(nation);
        });
    });

    @if(isset($invoice))
        @if($invoice->company->nazione != 'IT')
            extraEsteroFields('XX');
            console.log('ciaoo');
        @endif
    @endif



    </script>
@endpush
