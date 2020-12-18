<div class="row">
    @if($company->contacts()->exists())
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Cellulare</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($company->contacts as $contact)
                        <tr>
                            <td><i>{{$contact->pos}}</i> {{$contact->fullname}}</td>
                            <td>{{$contact->email}}</td>
                            <td>{{$contact->cellulare}}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{route('contacts.edit', $contact->id)}}"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-sm btn-warning" href="{{route('contacts.show', $contact->id)}}"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <hr>
    <a href="{{route('contacts.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Aggiungi contatto</a>
</div>
