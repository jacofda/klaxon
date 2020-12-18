<button type="button" class="btn bg-blue btn-sm sendToClient" data-id="{{$invoice->id}}" title="invia un'email al cliente con in allegato la fattura in pdf"><i class="fa fa-envelope"></i> Invia</button>

@if( $invoice->media()->pdf()->exists() )
    <a href="{{url('pdf/invoices/'.$invoice->id)}}" target="_blank" title="aggiorna PDF" class="btn bg-green btn-sm ml-1"><i class="fa fa-redo"></i> PDF</a>
    <a href="{{asset('storage/fe/pdf/inviate/'.$invoice->media()->pdf()->first()->filename)}}" title="scarica PDF" target="_blank" class="btn bg-green btn-sm ml-1"><i class="fa fa-file-pdf"></i> PDF</a>
@else
    <a href="{{url('pdf/invoices/'.$invoice->id)}}" target="_blank" class="btn bg-green btn-sm ml-1"><i class="fa fa-file-pdf"></i> PDF</a>
@endif

@can('invoices.write')
    @if($invoice->status == 0)
        <a href="{{url('invoices/'.$invoice->id.'/edit')}}" title="modifica fattura" class="btn bg-info btn-sm ml-1" ><i class="fa fa-edit"></i> Modifica</a>
        <button class="btn bg-red btn-sm ml-1 removeMe" id="removeI-{{$invoice->id}}"><i class="fa fa-trash"></i> Elimina</button>
    @endif
@endcan

@push('scripts')
<script>
$('button.sendToClient').on('click', function(){
    let token = "{{csrf_token()}}";
    $.post(baseURL+'pdf/send/'+$(this).attr('data-id'), {_token: token}).done(function( response ) {
        console.log(response);
        if(response == 'done')
        {
            new Noty({
                text: "Email Inviata",
                type: 'success',
                theme: 'bootstrap-v4',
                timeout: 2500,
                layout: 'topRight'
            }).show();
        }
        else if(response == 'error')
        {
            new Noty({
                text: "Errore",
                type: 'error',
                theme: 'bootstrap-v4',
                timeout: 2500,
                layout: 'topRight'
            }).show();
        }
        else
        {
            new Noty({
                text: response,
                type: 'warning',
                theme: 'bootstrap-v4',
                timeout: 2500,
                layout: 'topRight'
            }).show();
        }
    });
});
</script>
@endpush
