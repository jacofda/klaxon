<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{__('Create')}} SN: <b>{{$loop->iteration}}x {{$product->codice}}</b> - {{$product->name}}</h3>
    </div>
    <div class="card-body">
        <input type="hidden" name="id[]" value="">

        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>{{__('Company')}}</label>
                    {!! Form::select('company_id[]', $companies, $company_id, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>{{__('Order')}}</label>
                    {!! Form::select('erp_order_id[]', $orders, $order_id, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>{{__('Product')}}</label>
                    {!! Form::select('product_id[]', $snps, $input, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>{{__('Serial Number')}}</label>
                    {!! Form::text('sn[]', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>{{__('Unlocking Code')}}</label>
                    {!! Form::text('unlock_code[]', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
