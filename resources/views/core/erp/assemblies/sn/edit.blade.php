<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{__('Create') . ' SN'}}</h3>
    </div>
    <div class="card-body">
        <input type="hidden" name="id[]" value="{{$input->id}}">

        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>{{__('Company')}}</label>
                    {!! Form::select('company_id[]', $companies, $input->company_id, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>{{__('Order')}}</label>
                    {!! Form::select('erp_order_id[]', $orders, $input->erp_order_id, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>{{__('Product')}}</label>
                    {!! Form::select('product_id[]', $snps, $input->product_id, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>{{__('Serial Number')}}</label>
                    {!! Form::text('sn[]', $input->sn, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>{{__('Unlocking Code')}}</label>
                    {!! Form::text('unlock_code[]', $input->unlock_code, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
