<table>
    <thead>
        <tr>
            <th>RAGIONAE SOCIALE</th>
            <th>INDIRIZZO</th>
            <th>CAP</th>
            <th>COMUNE</th>
            <th>PROVINCIA</th>
            <th>NAZIONE</th>
            <th>LINGUA</th>
            <th>PRIVATO</th>
            <th>PEC</th>
            <th>PIVA</th>
            <th>CF</th>
            <th>SDI</th>
            <th>FORNITORE</th>
            <th>PARTNER</th>
            <th>TELEFONO</th>
            <th>EMAIL</th>
            <th>EMAIL_ORDINI</th>
            <th>EMAIL_FATTURAZIONE</th>
            <th>ESENZIONE</th>
            <th>CATEGORIA</th>
            <th>TIPO</th>
            <th>SCONTO TOTALE</th>
            <th>SCONTO 1</th>
            <th>SCONTO 2</th>
            <th>SCONTO 3</th>
            <th>NOTE</th>
        </tr>
    </thead>
    <tbody>
    @foreach($companies as $company)

        <tr>
            <td>{{$company->rag_soc}}</td>
            <td>{{$company->indirizzo}}</td>
            <td>{{$company->cap}}</td>
            <td>{{$company->citta}}</td>
            <td>{{$company->provincia}}</td>
            <td>{{$company->nazione}}</td>
            <td>{{$company->lingua}}</td>
            <td>
                @if($company->privato)
                    Sì
                @else
                    No
                @endif
            </td>
            <td>{{$company->pec}}</td>
            <td>{{$company->piva}}</td>
            <td>{{$company->cf}}</td>
            <td>{{$company->sdi}}</td>
            <td>
                @if($company->fornitore)
                    Sì
                @else
                    No
                @endif
            </td>
            <td>
                @if($company->partner)
                    Sì
                @else
                    No
                @endif
            </td>
            <td>{{$company->telefono}}</td>
            <td>{{$company->email}}</td>
            <td>{{$company->email_ordini}}</td>
            <td>{{$company->email_fatture}}</td>
            <td>
                @if($company->exemption_id)
                    {{$company->exemption->nome}}
                @endif
            </td>
            <td>
                @if($company->sector_id)
                    {{$company->sector->nome}}
                @endif
            </td>
            <td>
                @foreach($company->clients as $type)
                    @if($loop->last)
                        {{$type->nome}}
                    @else
                        {{$type->nome}} |
                    @endif
                @endforeach
            </td>
            <td>{{$company->sconto}}</td>
            <td>{{$company->s1}}</td>
            <td>{{$company->s2}}</td>
            <td>{{$company->s3}}</td>
            <td>"{{$company->note}}"</td>
        </tr>

    @endforeach
    </tbody>
</table>
