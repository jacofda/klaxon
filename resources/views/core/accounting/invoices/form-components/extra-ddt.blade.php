<div class="card card-outline card-info" id="extra-ddt" style="display:none;">
    <div class="card-header">
        <h3 class="card-title">Extra DDT</h3>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-sm-12 col-xl-6 d-none">

                <div class="form-group row">
                    <label class="col-sm-4 col-xl-8 col-form-label">Num. DDT*</label>
                    <div class="col-sm-8 col-xl-4">
                        {!! Form::text('ddt_n_doc', null, ['class' => 'form-control', 'maxlength' => '50']) !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 d-none">
                <div class="form-group row">
                    <label class="col-sm-4 col-xl-7 col-form-label">{{__('Date')}} DDT*</label>
                    <div class="col-sm-8 col-xl-5">
                        @php
                            if(isset($invoice))
                            {
                                $ddt_data_doc = is_null($invoice->ddt_data_doc) ? null : $invoice->ddt_data_doc->format('d/m/Y');
                            }
                            else
                            {
                                $ddt_data_doc = null;
                            }
                        @endphp
                        {!! Form::text('ddt_data_doc', $ddt_data_doc, ['class' => 'form-control', 'maxlength' => '10', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd/mm/yyyy']) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{__('Shipping with')}}</label>
                    <div class="col-sm-8">
                        {!! Form::select('delivery_company_id', $deliveryCompanies, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{__('Shipping type')}}</label>
                    <div class="col-sm-8">
                        {!! Form::select('tipo_spedizione', $dispatchTypes, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{__('Note')}}</label>
                    <div class="col-sm-8">
                        {!! Form::text('note_spedizione', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-xl-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-xl-8 col-form-label">Pack</label>
                    <div class="col-sm-8 col-xl-4">
                        {!! Form::select('colli_spedizione', [1=>1, 2=>2, 3=>3,4=>4,5=>5,6=>6,7=>8], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-xl-5 col-form-label">{{__('Weight')}}</label>
                    <div class="col-sm-8 col-xl-7">
                        <div class="input-group">
                            {!! Form::text('peso_spedizione', null, ['class' => 'form-control']) !!}
                            <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00 kg</span>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</div>

@push('scripts')
    <script>

    $('select[name="tipo_spedizione"]').select2({width:'100%', placeholder:"Tipo Spedizione" });
    $('select[name="delivery_company_id"]').select2({width:'100%', placeholder:"Azienda Spedizione" });

    //add extra fields for DDT
    const extraDDTFields = (t) => {
        var data = $('input[name="ddt_data_doc"]');
        if(t == 'D')
        {
            $('#extra-ddt').css({display: 'block'});
            if(data.val() == '')
            {
                data.val(moment().format('DD/MM/YYYY'));
            }
            data.inputmask();
        }
        else
        {
            data.val('');
            $('#extra-ddt').css('display', 'none');
        }
    }

    extraDDTFields($('select[name="tipo"]').find(':selected').val());

    </script>
@endpush
