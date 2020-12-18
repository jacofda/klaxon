<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{__('Data')}} {{__('Product')}} CRM</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Name')}} IT*</label>
                        {!! Form::text('nome_it', null, ['class' => 'form-control', 'required']) !!}
                        @include('jacofda::components.add-invalid', ['element' => 'nome'])
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Name')}} EN</label>
                        {!! Form::text('nome_en', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Name')}} DE</label>
                        {!! Form::text('nome_de', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Description')}}  IT</label>
                        {!! Form::textarea('descrizione_it', null, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Description')}}  EN</label>
                        {!! Form::textarea('descrizione_en', null, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Description')}}  DE</label>
                        {!! Form::textarea('descrizione_de', null, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Code')}}*</label>
                        {!! Form::text('codice', null, ['class' => 'form-control', 'required']) !!}
                        @include('jacofda::components.add-invalid', ['element' => 'codice'])
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Code')}} CRM</label>
                        {!! Form::text('codice_crm', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{__('Code')}} {{__('Supplier')}}</label>
                        {!! Form::text('codice_fornitore', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-md-3 col-xl-1">
                    <div class="form-group">
                        <label>{{__('Active')}}</label>
                        {!! Form::select('active', [ 1 => 'Si', 0 => 'No'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>{{__('Type')}}</label>
                        {!! Form::select('type_id', $types, null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-3">
                    <div class="form-group">
                        <label>{{__('Category')}}</label>
                        {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Purchase Price</label>
                        <div class="input-group">
                            {!! Form::text('prezzo_acquisto', null, ['class' => 'form-control input-decimal']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00 €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Retail Price</label>
                        <div class="input-group">
                            {!! Form::text('prezzo_retail', null, ['class' => 'form-control input-decimal']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00 €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Standard Price</label>
                        <div class="input-group">
                            {!! Form::text('prezzo_std', null, ['class' => 'form-control input-decimal']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00 €</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">ERP</h3>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>{{__('Group')}}</label>
                        {!! Form::select('group_id', $groups, null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-12 col-md-4 col-xl-3">
                    <div class="form-group">
                        <label>{{__('Supplier')}}</label>
                        {!! Form::select('company_id', $suppliers, null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>{{__('Component')}}</label>
                        {!! Form::select('acquistabile', [ 1 => 'Si', 0 => 'No'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>


                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Version</label>
                        {!! Form::text('versione', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-12 col-md-2 col-xl-1">
                    <div class="form-group">
                        <label>Unit</label>
                        {!! Form::select('unita', ['pz' => 'pz', 'mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'kg' => 'kg', 'lt' => 'lt'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Qta {{__('Box')}}</label>
                        <div class="input-group">
                            {!! Form::number('qta_confezione', null, ['class' => 'form-control']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text input-group-text-sm" id="basic-addon2">unit</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Time {{__('Supply')}}</label>
                        <div class="input-group">
                            {!! Form::number('tempo_fornitura', null, ['class' => 'form-control']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text input-group-text-sm" id="basic-addon2">giorni</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Cost {{__('Supply')}}</label>
                        <div class="input-group">
                            {!! Form::text('costo_fornitura', null, ['class' => 'form-control input-decimal']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00 €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>{{__('Require SN')}}</label>
                        {!! Form::select('has_sn', [0 => 'No', 1 => 'Yes'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Qta Min {{__('End Products')}}</label>
                        {!! Form::number('qta_min', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Qta Min {{__('Purchase')}}</label>
                        {!! Form::number('qta_min_acquisto', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Qta Min {{__('Store')}}</label>
                        {!! Form::number('qta_min_magazzino', null, ['class' => 'form-control']) !!}
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
    $('select[name="type_id"]').select2({placeholder: "Seleziona Tipologia", width:'100%'});
    $('select[name="category_id"]').select2({placeholder: "Seleziona Categoria", width:'100%'});
    $('select[name="group_id"]').select2({placeholder: "Seleziona Gruppo", width:'100%'});
    $('select[name="company_id"]').select2({placeholder: "Fornitore o Lavoratore", width:'100%'});
</script>
@stop
