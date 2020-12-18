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

<div class="col-md-12">
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">Inputs</h3>
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
                                    {!! Form::select('input[id][]', $products, $input->id, ['class' => 'form-control input']) !!}
                                    <div class="input-group-append" style="width:30%">
                                        {!!Form::number('input[qta][]', $input->pivot->qta, ['class' => 'form-control', 'placeholder' => 'qta'])!!}
                                        <a href="#" class="btn btn-primary add" title="aggiungi"><i class="fas fa-plus"></i></a>
                                        <a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                    <div class="col-12">
                        <div class="form-group">
                            @if(!isset($work)) <label>Input*</label> @endif

                            <div class="input-group">
                                {!! Form::select('input[id][]', $products, null, ['class' => 'form-control input']) !!}
                                <div class="input-group-append" style="width:30%">
                                    {!!Form::number('input[qta][]', null, ['class' => 'form-control', 'placeholder' => 'qta'])!!}
                                    <a href="#" class="btn btn-primary add" title="aggiungi"><i class="fas fa-plus"></i></a>
                                    <a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
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


let data = {!!$select!!};
data.unshift({text:"", id:""});
// let data = axios.get("//route('api.products.index')}}").then(function(response){
//     return response.data;
// })


let html ='<div class="col-12">'+
                '<div class="form-group">'+
                    '<div class="input-group">'+
                        '{!! Form::select("input[id][]", [], null, ["class" => "form-control input", "id" => "regex"]) !!}'+
                        '<div class="input-group-append" style="width:30%">'+
                            '{!!Form::number("input[qta][]", null, ['class' => "form-control", "placeholder" => "qta"])!!}'+
                            '<a href="#" class="btn btn-primary add" title="aggiungi"><i class="fas fa-plus"></i></a>'+
                            '<a href="#" class="btn btn-danger remove" title="elimina"><i class="fas fa-times"></i></a>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';



$('select[name="product_id"]').select2({placeholder: "Seleziona Prodotto Output", width:'100%'});
$('select[name="company_id"]').select2({placeholder: "Fornitore o Lavoratore", width:'100%'});
$('select.input').select2({placeholder: "Input per la lavorazione",width:'70%'});


$('.addingProduct').on('click', 'a.add', function(e){
    e.preventDefault();
    let newInput = "input-"+randomInteger(1, 1000);
    let newHtml = html.replace("regex", newInput);
    $('.addingProduct').append(newHtml);
    $('#'+newInput ).select2();
    $('#'+newInput ).select2({data:data});
    $('#'+newInput ).select2({placeholder: "Input per la lavorazione"});
})

function randomInteger(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


</script>
@stop
