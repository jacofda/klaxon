{!!Form::text('comment', session('comment'), ['class' => 'form-control d-none', 'id' => 'comment'])!!}

<div class="row mb-2">
    <div class="col-12 col-sm-6 col-xl-2">
        <div class="small-box bg-info">
            <div class="inner">
                <h3 class="mb-0"><span>€ </span> <span id="totale"></span></h3>
                <p>Costi</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card">
            <div class="card-header p-0 text-center">
                <h6 class="my-1">View</h6>
            </div>
            <div class="card-body p-0 text-center">
                <a href="#" class="btn btn-sm btn-info btn-block active viewProdotto">prodotto</a>
                <a href="#" class="btn btn-sm btn-info btn-block viewLavorazione mt-0">lavorazione</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-2 offset-xl-2">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title">Acquisto</h3>
            </div>
            <div class="card-body p-0">
                <a href="#" class="btn btn-block btn-primary creaAcquisto">Crea</a>
            </div>
            <div class="card-footer p-0 d-none">
                <a href="#" target=""_BLANK class="btn btn-block btn-secondary goToAcquisti">Vedi</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title">Lavorazione</h3>
            </div>
            <div class="card-body p-0">
                <a href="#" class="btn btn-block btn-success creaLavorazione">Crea </a>
            </div>
            <div class="card-footer p-0 d-none">
                <a href="#" target=""_BLANK class="btn btn-block btn-secondary goToLavorazione">Vedi</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title">Entrambi</h3>
            </div>
            <div class="card-body p-0">
                <a href="#" class="btn btn-block btn-warning creaLandA">Lavorazione + Acquisto</a>
            </div>
            <div class="card-footer p-0 d-none">
                <a href="#" target=""_BLANK class="btn btn-block btn-secondary goToOrdini">Vedi</a>
            </div>
        </div>
    </div>
</div>
