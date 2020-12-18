<div class="row">

    <div class="col-12 col-sm-6 col-lg-3 ">
        <div class="small-box bg-info">
            <div class="inner">
                <h3 class="mb-0">{{$totale}}</h3>
                <p>Totale</p>
            </div>
            <div class="icon"><i class="ion ion-bag"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 class="mb-0">{{$imposte}}</h3>
                <p>Imposte</p>
            </div>
            <div class="icon"><i class="ion ion-stats-bars"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="row">
            @foreach($categories as $expense => $total)
                <div class="col">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h6 class="mb-0">{{$total}}</h6>
                            <p class="mb-0">{{$expense}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</div>
