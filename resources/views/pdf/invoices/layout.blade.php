<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="{{public_path('css/pdf/b3.css')}}">
    <link rel="stylesheet" href="{{public_path('css/pdf/pdf.css')}}">
    <link rel="stylesheet" href="{{asset('css/pdf/b3.css')}}">
    <link rel="stylesheet" href="{{asset('css/pdf/pdf.css')}}">
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin-top: 2cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3.3cm;

        }
    </style>
</head>
<body>

<footer>
    <div class="row">
        <div class="col-xs-12" style="height:20px;width:100%;margin-bottom:15px; color:red; text-align:center; font-size:13px">
            <b>FATTURA NON VALIDA AI FINI FISCALI AI SENSI DELL'ART. 21 DPR 933/72<br>
                L'ORIGINALE E' DISPONIBILE ALL'INDIRIZZO DA VOI FORNITO OPPURE NELL'AREA A VOI RISERVATA DELL'AGENZIA DELLE ENTRATE.
            </b></div>

        @if(Jacofda\Klaxon\Models\Setting::FatturaFooterImg() != '')
            <img class="img-responsive" src="{{Jacofda\Klaxon\Models\Setting::FatturaFooterImg()}}">
        @else
            <div class="col-xs-12" style="height:2px;width:100%;background:red;"></div>
        @endif

        <div class="col-xs-6 text-left">
            <p style="margin:10px 0 0 20px; line-height:17px; font-size:14px;"><b>{{$company->rag_soc}}</b><br>
                {{$company->indirizzo}}<br>
                {{$company->cap}} {{$company->citta}} ({{$company->prov}})<br>
                Telefono {{$company->tel}}
            </p>
        </div>
        <div class="col-xs-6 text-right">
            <p style="margin:10px 20px 0 0; line-height:17px; font-size:14px;">{{$company->banca}}<br>
            {{$company->IBAN}}<br>
            CF {{$company->piva}} - PIVA {{$company->piva}}<br>
            {{$company->email}} - {{$company->web}}</p>
        </div>
    </div>
</footer>


@yield('content')







</body>
</html>
