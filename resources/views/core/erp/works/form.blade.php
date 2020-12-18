<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Definizione</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome IT*</label>
                        {!! Form::text('nome_it', null, ['class' => 'form-control', 'required']) !!}
                        @include('jacofda::components.add-invalid', ['element' => 'nome'])
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome EN</label>
                        {!! Form::text('nome_en', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome DE</label>
                        {!! Form::text('nome_de', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrizione</label>
                        {!! Form::textarea('descrizione', null, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="form-group">
                        <label>Codice*</label>
                        {!! Form::text('codice', null, ['class' => 'form-control', 'required']) !!}
                        @include('jacofda::components.add-invalid', ['element' => 'codice'])
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="form-group">
                        <label>Fornitore*</label>
                        {!! Form::select('company_id', $suppliers, null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="form-group">
                        <label>Output*</label>
                        {!! Form::select('product_id', $products, null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

            </div>





            <div class="row">


                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Costo Produzione</label>
                        <div class="input-group">
                            {!! Form::text('cost', null, ['class' => 'form-control input-decimal']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text input-group-text-sm" id="basic-addon2">00.00 €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-xl-2">
                    <div class="form-group">
                        <label>Tempo Produzione</label>
                        <div class="input-group">
                            {!! Form::number('time', null, ['class' => 'form-control']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text input-group-text-sm" id="basic-addon2">giorni</span>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-12 col-md-3 col-xl-1">
                    <div class="form-group">
                        <label>Versione</label>
                        {!! Form::text('versione', null, ['class' => 'form-control']) !!}
                    </div>
                </div>




            </div>

        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">Inputs Lavorazione</h3>
        </div>
        <div class="card-body">

            <div class="row addingProduct">

                @if(isset($work))
                    @foreach($work->inputs as $input)
                        <div class="col-12">
                            <div class="form-group">
                                @if($loop->index == 0)
                                    <label>Input*</label>
                                @endif
                                <div class="input-group">
                                    {!! Form::select('input[id][]', $products, $input->id, ['class' => 'form-control']) !!}
                                    <div class="input-group-append" style="width:100px">
                                        {!!Form::number('input[qta][]', $input->pivot->qta, ['class' => 'form-control', 'placeholder' => 'qta'])!!}
                                        <a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">Inputs Disponibili</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-sm table-xs tlav">
                    <thead>
                        <tr>
                            <th>Codice</th>
                            <th>Nome</th>
                            <th data-sortable="false"></th>
                            <th data-sortable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tp as $product)
                            <tr class="row-input-{{$product->id}}">
                                <td id="prod-code-{{$product->id}}">{{$product->codice}}</td>
                                <td id="prod-nome-{{$product->id}}">{{$product->nome_it}}</td>
                                <td>
                                    <div class="form-group" style="width:100px; margin-top:5px;margin-bottom:5px;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <a href="#" class="addP input-group-text input-group-text-sm bg-primary"><i class="fas fa-plus"></i></a>
                                            </div>
                                            <input type="number" class="form-control form-control-sm" min="1" value="1" id="prod-{{$product->id}}">
                                            <div class="input-group-append">
                                                <a href="#" class="subP input-group-text input-group-text-sm bg-danger"><i class="fas fa-minus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-success addToCart" data-prod="{{$product->id}}"><i class="fas fa-cart-plus"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(isset($work))
    @include('jacofda::core.erp.checks.form', ['model' => $work])
@else
    @include('jacofda::core.erp.checks.form', ['model' => null])
@endif


<div class="col-12">
    <div class="card">
        <button type="submit" class="btn btn-block btn-success btn-lg" id="submitForm"><i class="fa fa-save"></i> Salva</button>
    </div>
</div>

</div>

@section('scripts')
<script>


let topt = window.tableOptions;
topt.pageLength = 10;
$("#table").DataTable(topt);

let data = {!!$select!!};
data.unshift({text:"", id:""});

$('select[name="product_id"]').select2({placeholder: "Seleziona Prodotto Output", width:'100%'});
$('select[name="company_id"]').select2({placeholder: "Fornitore o Lavoratore", width:'100%'});
$('select.input').select2({placeholder: "Input per la lavorazione",width:'70%'});

$('.addingProduct').on('click', 'a.remove', function(e){
    e.preventDefault();
    $(this).parent('div').parent('div').parent('div').parent('div').remove();
    console.log('clicked');
})

function randomInteger(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

$('.tlav').on('click', 'a.addP', function(e){
    e.preventDefault();
    let val = $(this).parent('div').siblings('input').val();
    $(this).parent('div').siblings('input').val(parseInt(val)+1);
});

$('.tlav').on('click', 'a.subP',function(e){
    e.preventDefault();
    let val = $(this).parent('div').siblings('input').val();
    if(parseInt(val)>0)
    {
        $(this).parent('div').siblings('input').val(parseInt(val)-1);
    }
});

$('.tlav').on('click', 'a.addToCart', function(e){
    e.preventDefault();
    let prodId = $(this).attr('data-prod');
    let code = $('td#prod-code-'+prodId).text();
    let name = $('td#prod-nome-'+prodId).text();
    let qta = $('input#prod-'+prodId).val();
    if(parseInt(qta) > 0)
    {
        let htl ='<div class="col-12">'+
                        '<div class="form-group">'+
                            '<div class="input-group">'+
                                '<select class="form-control" id="regex" name="input[id][]"></select>'+
                                '<div class="input-group-append" style="width:30%">'+
                                    '<input class="form-control" placeholder="qta" name="input[qta][]" type="number" value="'+qta+'">'+
                                    '<a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
        let newInput = "input-"+randomInteger(1, 1000);
        let newHtml = htl.replace("regex", newInput);
        $('.addingProduct').append(newHtml);
        $('#'+newInput ).select2();
        $('#'+newInput ).select2({data:data});
        $('#'+newInput ).val(prodId).trigger('change');
        console.log($(this).parent('td').parent('tr').remove())
    }
})


</script>
@stop
