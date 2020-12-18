<html>
<header>
    <style>

    </style>
</header>
<body>

<table width="100%" cellspacing="0" cellpadding="10" align="left" style="margin-top:20px; margin-bottom:20px">
    <tr>
        <td width="30%" class="testo" align="left">
            <b>Goods Destination</b><br><br>
            {{$supplier->rag_soc}}<br>
            {{$supplier->indirizzo}}<br>
            {{$supplier->cap . ' ' . $supplier->citta . ' (' . $supplier->provincia.')'}}<br>
            {{$supplier->nazione}}

        </td>
        <td width="5%" class="testo" align="left">
            &nbsp;
        </td>
        <td width="30%" class="testo" align="left">
            <b>Esteemed</b><br><br>
            {{$supplier->rag_soc}}<br>
            {{$supplier->indirizzo}}<br>
            {{$supplier->cap . ' ' . $supplier->citta . ' (' . $supplier->provincia.')'}}<br>
            {{$supplier->nazione}}
        </td>
        <td width="5%" class="testo" align="left">
            &nbsp;
        </td>
        <td width="30%" class="testo" align="left">
            <img style="text-align:center;display:block;margin-left:auto;margin-right:auto; width:100%;" src="{{Jacofda\Klaxon\Models\Setting::FatturaLogo()}}" />
        </td>
    </tr>

</table>
<br>
