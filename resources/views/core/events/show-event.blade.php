<div class="modal" tabindex="-1" role="dialog" id="calendar-modal-showEvent">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header" style="display:block;position:relative;">
                <h4 id="e-title" class="mb-0"></h4>
                <h5 class="mb-0"><b><span id="e-data"></span></b></h5>
                <button style="position:absolute; right: 3%;top: 20%;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="e-summary"></div>
                </div>
                <div class="row">
                    <div class="col-12" id="e-location"></div>
                </div>
                <div class="row" id="e-dynamic">

                </div>
            </div>

            <div class="modal-footer" style="display:block;">
                <div class="row">
                    <div class="text-left col">
                        <a href="#" class="btn btn-danger e-delete">Elimina</a>
                        <a href="#" class="btn btn-success e-done">Finito</a>
                        <form action="" method="POST" class="d-none e-delete-form">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">ELIMINA</button>
                        </form>
                    </div>
                    <div class="text-right col">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <a href="#" class="btn btn-warning" id="e-edit">Modifica</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>

    $('a.showEvent').on('click', function(e){
        e.preventDefault();
        console.log('$this');
        console.log($(this));
        showModal($(this).attr('data-eventId'));
    });

    function showModal(infoEventId)
    {
        let url = "{{url('events')}}/"+infoEventId;
        $.get(url, function(data){
            const response = data[0];
            console.log(response);
            let companies = '';
            let users = '';
            let contacts = '';
            if(response.companies.length)
            {
                console.log(response.companies);
                const company = response.companies[0];
                companies = '<div class="col-4">';
                companies += '<h6 class="mb-0 text-underline text-primary">Azienda</h6>';
                companies += '<h6>'+company.rag_soc+'</h6>';
                companies += '</div>';
            }

            if(response.users.length)
            {
                console.log('ho users');
                users += '<div class="col-4">';
                users += '<h6 class="mb-0 text-underline text-primary">Utenti</h6>';
                response.contacts.forEach( el => {
                        users += '<h6 class="mb-0">'+el.nome+' '+el.cognome+'</h6>';
                    }
                );
                users += '</div>';
            }

            if(response.contacts.length)
            {
                console.log('ho contacts');
                contacts += '<div class="col-4">';
                contacts += '<h6 class="mb-0 text-underline text-primary">Contatti</h6>';
                response.contacts.forEach( el => {
                        contacts += '<h6 class="mb-0">'+el.nome+' '+el.cognome+'</h6>';
                    }
                );
                contacts += '</div>';
            }

            if(response.location)
            {
                let linkLocation =  '<div class="mb-2"><b>Luogo</b>: <a href="https://maps.google.com/?q='+response.location+'" target="_BLANK">'+response.location+'</a></div>';
                $('#e-location').html(linkLocation);
            }
            else
            {
                $('#e-location').html('');
            }

            $('#e-title').html(response.title);
            let da_a = moment(response.starts_at).format('LLLL') + " alle " + moment(response.ends_at).format('LT');
            if(parseInt(response.allday) === 1)
            {
                 da_a = "da "+ moment(response.starts_at).format('dddd D MMMM')+" a " + moment(response.ends_at).format('dddd D MMMM YYYY');
            }
            $('#e-data').html(da_a);
            if(response.summary)
            {
                $('#e-summary').html('<p class="mb-3">'+response.summary+'</p>');
            }
            else
            {
                $('#e-summary').html('');
            }

            if(parseInt(response.done) === 1)
            {
                $('a.e-done').css('display', 'none');
            }

            $('#e-dynamic').html(companies+contacts+users);
            let url = "{{url('events')}}/"+infoEventId;
            $('#e-edit').attr('href', url+'/edit');
            $('#calendar-modal-showEvent').modal('show');
            console.log('show event');

            $('a.e-delete').on('click', function(e){
                e.preventDefault();
                let form = $(this).siblings('form');
                form.attr('action', url);


                var notyConfirm = new Noty({
                    text: '<h6 class="mb-0">Siete sicuri?</h6><hr class="mt-0 mb-1">',
                    timeout: false,
                    modal: true,
                    layout: 'center',
                    closeWith: 'button',
                    theme: 'bootstrap-v4',
                    buttons: [
                        Noty.button('Annulla', 'btn btn-light ml-5', function () {
                            notyConfirm.close();
                        }),
                        Noty.button('Sì, elimina <i class="fa fa-trash"></i>', 'btn btn-danger ml-1', function () {
                                form.submit();
                            },
                            {id: 'button1', 'data-status': 'ok'}
                        )
                    ]
                }).show();


            });

            $('a.e-done').on('click', function(e){

                $.post( "{{url('api/events')}}/"+infoEventId+"/done", { _token: "{{csrf_token()}}"}).done(function( data ) {
                    console.log( "Data Loaded: " + data );
                    $('#calendar-modal-showEvent').modal('hide');
                });

            });
        });
    }

    </script>
@endpush
