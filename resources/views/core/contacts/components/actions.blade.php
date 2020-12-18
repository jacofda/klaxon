{!! Form::open(['method' => 'delete', 'url' => route('contacts.destroy', $contact->id), 'id' => "form-".$contact->id]) !!}

    <a href="{{$contact->url}}/edit" class="btn btn-warning btn-icon btn-sm"><i class="fa fa-edit"></i></a>

    @can('contacts.delete')
        <button type="submit" id="{{$contact->id}}" class="btn btn-danger btn-icon btn-sm delete"><i class="fa fa-trash"></i></button>
    @endcan

    @can('companies.write')
        @if(is_null($contact->company))
            <a href="#" class="btn btn-info btn-icon btn-sm makeCompany" title="crea azienda" data-id="{{$contact->id}}"><i class="fa fa-user-tie"></i></a>
        @endif
    @endcan

    @can('users.write')
        @if(is_null($contact->user_id) && $contact->isNotOfType([1,2]))
            <a href="#" class="btn btn-secondary btn-icon btn-sm makeUser" title="crea utente" data-id="{{$contact->id}}"><i class="fa fa-user"></i></a>
        @endif
    @endcan

{!! Form::close() !!}

@can('companies.write')
    {!! Form::open(['url' => url('contacts/make-company'), 'id' => "makeCompany-".$contact->id, 'class' => 'd-none']) !!}
        <input type="hidden" name="id" value="{{$contact->id}}" />
        <button type="submit"></button>
    {!! Form::close() !!}
@endcan

@can('users.write')
    {!! Form::open(['url' => url('contacts/make-user'), 'id' => "makeUser-".$contact->id, 'class' => 'd-none']) !!}
        <input type="hidden" name="id" value="{{$contact->id}}" />
        <button type="submit"></button>
    {!! Form::close() !!}
@endcan


@push('scripts')
<script>

    $('a.makeCompany').on('click', function(e){
        e.preventDefault();
        $('form#makeCompany-'+$(this).attr('data-id')).submit();
    });

    $('a.makeUser').on('click', function(e){
        e.preventDefault();
        $('form#makeUser-'+$(this).attr('data-id')).submit();
    });

</script>
@endpush
