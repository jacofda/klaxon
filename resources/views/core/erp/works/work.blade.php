
<div class="col-md-12">
    <div class="card" style="background-color:transparent; box-shadow:none;">
        <div class="card-body p-0" >


            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="font-weight-bold w-100 card-title text-center">DATI</h3>
                    </div>
                    <div class="card-body">
                        <p>{{$work->descrizione}}</p>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Fornitore: </b> {{$work->supplier->rag_soc}}</p>
                            </div>
                            <div class="col-4">
                                <p><b>Costo: </b> € {{number_format($work->cost, 2, ',', '.')}}</p>
                            </div>
                            <div class="col-4">
                                <p><b>Tempo Lavorazione: </b> {{$work->time}} giorni</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid content-row text-center">
                <div class="row">
                    <div class="col-sm-4 relative">
                        <div class="card bg-warning h-100">
                            <div class="card-header">
                                <h3 class="font-weight-bold w-100 card-title text-center">INPUTS</h3>
                            </div>
                            <div class="card-body h-100 d-flex justify-content-center align-items-center">
                                <span>
                                    @foreach($work->componenti as $input)
                                        {{$input->product->codice}} x {{$input->qta}}<br>
                                        <small><a href="{{route('products.show', $input->product->id)}}">{{$input->product->nome_it}}</a></small><br>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                        <div style="position:absolute;top:45%;right:-1.2%;"><i class="fas fa-arrow-right fa-2x"></i></div>
                    </div>
                    <div class="col-sm-4 relative">
                        <div class="card text-white bg-info h-100">
                            <div class="card-header">
                                <h3 class="font-weight-bold w-100 card-title text-center">LAVORAZIONE</h3>
                            </div>
                            <div class="card-body h-100 d-flex justify-content-center align-items-center">
                                <span>{{$work->codice}} <br><small><a style="color:#d7daff;" href="{{route('works.show', $work->id)}}">{{$work->nome_it}}</a></small></span>
                            </div>
                        </div>
                        <div style="position:absolute;top:45%;right:-1.2%;"><i class="fas fa-arrow-right fa-2x"></i></div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card text-white bg-success h-100">
                            <div class="card-header">
                                <h3 class="font-weight-bold w-100 card-title text-center">OUTPUT</h3>
                            </div>
                            <div class="card-body h-100 d-flex justify-content-center align-items-center">
                                <span>{{$work->product->codice}}<br><small><a style="color:#82ff4e;" href="{{route('products.show', $work->product->id)}}">{{$work->product->nome_it}}</a></small></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
