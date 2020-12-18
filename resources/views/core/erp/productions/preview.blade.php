@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('erp.orders.index')}}">{{__('Orders')}}</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Work') . " " . __('Preview')])

@section('content')

@include('jacofda::core.erp.productions.preview.actions')

    <div id="xProdotti" >
        <div class="row mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{__('All products')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    @include('jacofda::core.erp.productions.preview.products-table')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
<script>
    $('body').addClass('sidebar-collapse');

    function mutateCollection(obj = null)
    {
        let cols;
        if(obj === null)
        {
            cols = {!!json_encode($collections)!!};
        }
        else
        {
            cols = obj;
        }
        let products = [];
        let qta = 0;
        var key;
        var k;
        for (key in cols) {
            if (cols.hasOwnProperty(key) && /^0$|^[1-9]\d*$/.test(key) && key <= 4294967294) {
                for(k in cols[key])
                {
                    if(Number.isInteger(cols[key][k]))
                    {
                        qta = cols[key][k];
                    }
                    else
                    {
                        for(const v of cols[key][k])
                        {
                            products.push(v);
                        }
                    }

                }
            }
        }
        return {'products': products, 'qta': qta};
    }

    let products = mutateCollection();

    function calculateTotal(obj)
    {
        let total = 0;
        for (const product of obj.products) {

            if(product.pivot.hasOwnProperty('extraQta'))
            {
                total += (product.costo_fornitura * product.pivot.qta) * product.pivot.extraQta;
            }
            else
            {
                total += (product.costo_fornitura * product.pivot.qta) * obj.qta;
            }
        }
        total = total.toFixed(2);
        $('span#totale').text(total);
        return total;
    }

    calculateTotal(products);


    function update(obj, id, newQ)
    {
        let new_obj = {'qta': obj.qta};
        new_obj.products = [];
        for (const product of obj.products) {
            if(product.id == id)
            {
                let new_product = { ...product, pivot:{
                    work_id: product.pivot.work_id,
                    input_id: product.pivot.input_id,
                    qta: product.pivot.qta,
                    extraQta: newQ
                }};
                new_obj.products.push(new_product);
            }
            else
            {
                new_obj.products.push(product);
            }
        }
        return new_obj;
    }

    function mutateAcquisto(obj)
    {
        let mother = 'div#xProdotti';
        new_obj = [];

        for (const product of obj.products) {
            if(product.acquistabile === 1)
            {
                new_obj.push({
                    'id': product.id,
                    qta: parseInt($(mother+' input#prod-'+product.id).val())
                });
            }
        }
        return new_obj;
    }


    function mutateLavorazione(obj)
    {
        let initial = {!!json_encode( session('products') )!!};

        let starter = [];
        for (var i in initial)
        {
            let start = {id: i, qta: initial[i]};
            starter.push(start);
        }

        let mother = 'div#xProdotti';

        new_obj = [];

        for (const product of obj.products) {
            let item = {
                id: product.id,
                qta: parseInt($(mother+' input#prod-'+product.id).val()),
                output_id: parseInt($(mother+' input#prod-'+product.id).attr('data-output')),
                work: parseInt($(mother+' input#prod-'+product.id).attr('data-work'))
            }

            if(item.output_id == starter[0].id)
            {
                item.output_qta = parseInt(starter[0].qta);
            }
            else
            {
                item.output_qta = parseInt($(mother+' input#prod-'+item.output_id).val());
            }
            new_obj.push(item);
        }
        return new_obj;
    }



    $('a.addP').on('click', function(e){
        e.preventDefault();
        let val = parseInt($(this).parent('div').siblings('input').val());
        let newQ = val+1;
        $(this).parent('div').siblings('input').val(newQ);

        products = update(products, $(this).attr('data-id'), newQ);
        calculateTotal(products);

        if($(this).attr('data-children'))
        {
            let children = $(this).attr('data-children').split(',');
            for(k in children)
            {
                $('input#prod-'+children[k]).val(parseInt($('input#prod-'+children[k]).attr('data-multiplier'))*newQ);
                products = update(products, children[k], newQ);
                calculateTotal(products);
            }
        }
    });

    $('a.subP').on('click', function(e){
        e.preventDefault();
        let val = parseInt($(this).parent('div').siblings('input').val());
        if(val>0)
        {
            let newQ = val-1;
            $(this).parent('div').siblings('input').val(newQ);
            products = update(products, $(this).attr('data-id'), newQ);
            calculateTotal(products);

            if($(this).attr('data-children'))
            {
                let children = $(this).attr('data-children').split(',');
                for(k in children)
                {
                    $('input#prod-'+children[k]).val(parseInt($('input#prod-'+children[k]).attr('data-multiplier'))*newQ);
                    products = update(products, children[k], newQ);
                    calculateTotal(products);
                }
            }
        }
    });



    $('a.viewProdotto').on('click', function(e){
        e.preventDefault();
        $(this).addClass('active');
        $('a.viewLavorazione').removeClass('active');
        $('div#xProdotti').removeClass();
        $('div#xLavorazioni').removeClass().addClass('d-none');
    });

    $('a.viewLavorazione').on('click', function(e){
        e.preventDefault();
        $(this).addClass('active');
        $('a.viewProdotto').removeClass('active');
        $('div#xLavorazioni').removeClass();
        $('div#xProdotti').removeClass().addClass('d-none');
    });

    $('a.creaAcquisto').on('click', function(e){
        e.preventDefault();
        let productsAcquisto = mutateAcquisto(products);

        axios.post("{{route('erp.orders.create-purchase.productions')}}", {
            _token: token,
            pa: productsAcquisto,
            comment: $('input#comment').val()
          })
          .then(function (response) {
              if(response.status == 200)
              {
                  new Noty({
                      text: "Acquisti creati",
                      type: 'success',
                      theme: 'bootstrap-v4'
                  }).show();

                  $('a.goToAcquisti').attr('href', baseURL+response.data);
                  $('a.goToAcquisti').parent('div').removeClass('d-none');
              }
          })
          .catch(function (error) {
              console.log(error);
          });
    });


    $('a.creaLavorazione').on('click', function(e){
        e.preventDefault();
        let productsLavorazione = mutateLavorazione(products);

        axios.post("{{route('erp.orders.create-production.productions')}}", {
            _token: token,
            pl: productsLavorazione,
            comment: $('input#comment').val()
          })
          .then(function (response) {
            console.log(response);
            if(response.status == 200)
            {
                new Noty({
                    text: "Lavorazione creata",
                    type: 'success',
                    theme: 'bootstrap-v4'
                }).show();

                $('a.goToLavorazione').attr('href', baseURL+'erp/orders/productions/'+response.data);
                $('a.goToLavorazione').parent('div').removeClass('d-none');
            }

          })
          .catch(function (error) {
              console.log(error);
          });
    });


    $('a.creaLandA').on('click', function(e){
        e.preventDefault();
        let productsLavorazione = mutateLavorazione(products);
        let productsAcquisto = mutateAcquisto(products);

        axios.post("{{route('erp.orders.create-purchase-production.productions')}}", {
            _token: token,
            pl: productsLavorazione,
            pa: productsAcquisto,
            comment: $('input#comment').val()
          })
          .then(function (response) {
            console.log(response);
            if(response.status == 200)
            {
                new Noty({
                    text: "Lavorazione creata",
                    type: 'success',
                    theme: 'bootstrap-v4'
                }).show();

                $('a.goToOrdini').attr('href', baseURL+response.data);
                $('a.goToOrdini').parent('div').removeClass('d-none');
            }

          })
          .catch(function (error) {
              console.log(error);
          });
    });



</script>
@stop
