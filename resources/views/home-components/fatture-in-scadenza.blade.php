<div class="col-6">
    <div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title">Fatture in scadenza da saldare</h3>
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
                @foreach(Jacofda\Klaxon\Models\Invoice::inScadenzaPrev(30) as $invoice)
                    <tr>
                        <td>{{$invoice->numero}}</td>
                        <td>{{$invoice->company->rag_soc}}</td>
                        <td>{{$invoice->data_scadenza->format('d/m/Y')}}</td>
                        <td>{{Jacofda\Klaxon\Models\Primitive::NF($invoice->imponibile+$invoice->iva)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>
