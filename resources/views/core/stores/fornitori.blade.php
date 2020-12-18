@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => 'Mag. Fornitori'])


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mag. Fornitori</h3>
                    <div class="card-tools">
                        <div class="btn-group" role="group">
                            @can('users.write')
                                <a href="{{route('stores.create')}}"class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Prodotto a Fornitore</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Codice</th>
                                    <th>Nome</th>
                                    <th>Versione</th>
                                    <th>Gruppo</th>
                                    <th>Mag. Fornitore</th>
                                    <th data-sortable="false"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stores as $item)
                                    <tr id="row-{{$item->id}}">
                                        <td>{{$item->product->codice}}</td>
                                        <td>{{$item->product->name}}</td>
                                        <td>{{$item->product->versione}}</td>
                                        <td>{{$item->product->group->nome}}</td>
                                        <td>{{$item->company->rag_soc}}</td>
                                        <td>
                                            <div class="input-group" styel="max-width:100px;">
                                                <input type="number" value="{{$item->qta}}" class="form-control form-control-sm" />
                                                <div class="input-group-append">
                                                    <a href="#" class="saveQta input-group-text input-group-text bg-success" data-magazzino="{{$item->company_id}}" data-id="{{$item->product->id}}"><i class="fas fa-save"></i></a>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script>
    $("#table").DataTable(window.tableOptions);

    $('a.saveQta').on('click', function(e){
        e.preventDefault();
        let qta = parseInt($(this).parent('div').siblings('input').val());
        let product_id = parseInt($(this).attr('data-id'));
        let company_id = parseInt($(this).attr('data-magazzino'));

        console.log(qta, product_id, company_id);

        axios.post("{{route('stores.update')}}", {
            _token: token,
            qta: qta,
            product_id: product_id,
            company_id: company_id
          })
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
              console.log(error);
          });
    });


        $('a#menu-erp-store-external').addClass('active');
        $('a#menu-erp-store-external').parent('li').parent('ul.nav-treeview').css('display', 'block');
        $('a#menu-erp-store-external').parent('li').parent('ul').parent('li.has-treeview ').addClass('menu-open');

</script>
@stop
