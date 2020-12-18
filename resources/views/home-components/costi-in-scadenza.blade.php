<div class="col-6">
    <div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title">Costi in scadenza da saldare</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <th>Numero</th>
                <th>Fornitore</th>
                <th>Scadenza</th>
                <th>Totale</th>
            </thead>
            <tbody>
                @foreach(Jacofda\Klaxon\Models\Cost::inScadenzaPrev(30) as $cost)
                    <tr>
                        <td>{{$cost->numero}}</td>
                        <td>{{$cost->company->rag_soc}}</td>
                        <td>{{$cost->data_scadenza->format('d/m/Y')}}</td>
                        <td>{{$cost->totale_formatted}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>
