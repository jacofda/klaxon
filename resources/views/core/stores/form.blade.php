<div class="col-md-8 offset-md-2">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Qta*</label>
                    {!! Form::number('qta', null, ['class' => 'form-control', 'required']) !!}
                    @include('jacofda::components.add-invalid', ['element' => 'qta'])
                </div>
            </div>


            <div class="col-12">
                <div class="form-group">
                    <label>Prodotto*</label>
                    {!! Form::select('product_id', $products, null, ['class' => 'form-control', 'required']) !!}
                    @include('jacofda::components.add-invalid', ['element' => 'product_id'])
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label>Fornitore*</label>
                    {!! Form::select('company_id', $suppliers, null, ['class' => 'form-control', 'required']) !!}
                    @include('jacofda::components.add-invalid', ['element' => 'company_id'])
                </div>
            </div>
        </div>
        <div class="card-footer p-0">
            <button type="submit" class="btn btn-block btn-success btn-lg" id="submitForm"><i class="fa fa-save"></i> Salva</button>
        </div>
    </div>
</div>


@section('scripts')
<script>
    $('select[name="product_id"]').select2({placeholder:"Seleziona un Prodotto"});
    $('select[name="company_id"]').select2({placeholder:"Seleziona un Fornitore"});
</script>
@stop
