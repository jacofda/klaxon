<?php

namespace Jacofda\Klaxon\Models\Fe;

use \Log;
use \File;
use \Exception;
use \Storage;
use \SimpleXMLElement;
use Jacofda\Klaxon\Models\Fe\{Primitive, Xml};
use Jacofda\Klaxon\Models\{Company, Invoice, Item, Exemption};

class InvoiceToXml extends Primitive
{

    public function __construct(Invoice $invoice, $setting)
    {
        $this->invoice = $invoice;
        $this->client = $invoice->company;
        $this->items = $invoice->items;
        $this->cedente = $setting;
        $this->types = config('fe.types');
        $this->payment_methods = config('fe.payment_methods');
        $this->xml = new Xml($setting);
    }

    public function init()
    {
        $template = $this->xml->createXml();

        $header = $template->FatturaElettronicaHeader;
            $this->datiTrasmissione($header);
            $this->datiCedente($header);
            $this->datiCommittente($header);

        $body = $template->FatturaElettronicaBody;
            $this->datiGeneraliDocumento($body);
            $this->datiBeniServizi($body);
            $this->datiPagamento($body);

        return $this->xml->saveXml($template, 'inviate', $this->invoice);

    }

    public function datiTrasmissione($header)
    {
        $DatiTrasmissione = $header->DatiTrasmissione;
        $DatiTrasmissione->ProgressivoInvio = $this->invoice->id;
        return true;
    }

    public function datiCedente($header)
    {
        $DatiAnagrafici = $header->CedentePrestatore->DatiAnagrafici;
        $Sede = $header->CedentePrestatore->Sede;

        $DatiAnagrafici->IdFiscaleIVA->IdPaese = $this->cedente->nazione;
        $DatiAnagrafici->IdFiscaleIVA->IdCodice = $this->cedente->piva;
        $DatiAnagrafici->CodiceFiscale = $this->cedente->piva;
        $DatiAnagrafici->Anagrafica->Denominazione = $this->cedente->rag_soc;
        $DatiAnagrafici->RegimeFiscale = $this->cedente->regime;

        $Sede->Indirizzo = $this->cedente->indirizzo;
        $Sede->CAP = $this->cedente->cap;
        $Sede->Comune = $this->cedente->citta;
        $Sede->Provincia = $this->cedente->prov;
        $Sede->Nazione = $this->cedente->nazione;

        return true;
    }


    public function datiCommittente($header)
    {
        $DatiAnagrafici = $header->CessionarioCommittente->DatiAnagrafici;
        $Sede = $header->CessionarioCommittente->Sede;

        if($this->client->piva != "")
        {
            $IdFiscaleIVA = $DatiAnagrafici->addChild('IdFiscaleIVA');
            $IdFiscaleIVA->addChild('IdPaese', $this->client->nazione);
            $IdFiscaleIVA->addChild('IdCodice', $this->client->piva);
        }
        else
        {
            $DatiAnagrafici->addChild('CodiceFiscale', $this->client->cf);
        }

        $Anagrafica = $DatiAnagrafici->addChild('Anagrafica');
        $Anagrafica->addChild('Denominazione', $this->client->rag_soc);

        $Sede->Indirizzo = $this->client->indirizzo;
        $Sede->CAP = $this->client->cap;
        $Sede->Comune = $this->client->citta;
        if ($this->client->nazione == 'IT')
        {
            $Sede->addChild('Provincia', $this->client->prov);
        }
        $Sede->addChild('Nazione', $this->client->nazione);
    }

    public function datiGeneraliDocumento($body)
    {
        $DatiGeneraliDocumento = $body->DatiGenerali->DatiGeneraliDocumento;

        if (!array_key_exists($this->invoice->tipo, $this->types))
        {
            $this->notify($this->invoice, "SEND: datiGeneraliDocumento(): tipo documento non gestito: ".$this->invoice->tipo);
            return false;
        }

        $DatiGeneraliDocumento->TipoDocumento = $this->types[$this->invoice->tipo];
        $DatiGeneraliDocumento->Data = $this->invoice->data->format('Y-m-d');

        if(intval($this->invoice->numero))
        {
            $DatiGeneraliDocumento->Numero = 'FPR '.$this->invoice->numero.'/'.$this->invoice->data->format('y');
        }
        else
        {
            $DatiGeneraliDocumento->Numero = $this->invoice->numero;
        }

        if( ($this->invoice->bollo > 0) )
        {
            $linea = $DatiGeneraliDocumento->addChild('DatiBollo');
            $linea->addChild('BolloVirtuale', "SI");
            $linea->addChild('ImportoBollo', $this->decimal($this->invoice->bollo));
        }

        if( ($this->invoice->ritenuta > 0) )
        {
            $linea = $DatiGeneraliDocumento->addChild('DatiRitenuta');
            $linea->addChild('TipoRitenuta', "RT01");
            $linea->addChild('ImportoRitenuta', $this->decimal($this->invoice->ritenuta));
            $linea->addChild('AliquotaRitenuta', $this->decimal($this->invoice->perc_ritenuta));
            $linea->addChild('CausalePagamento', 'A');
        }

        $DatiGeneraliDocumento->addChild('ImportoTotaleDocumento', $this->decimal($this->invoice->total));

        if ($this->invoice->pa_n_doc)
        {
            $linea = $DatiGeneraliDocumento->addChild('DatiOrdineAcquisto');
            $linea->addChild('IdDocumento', $this->invoice->pa_n_doc);
            if ($this->invoice->pa_cup)
            {
                $linea->addChild('CodiceCUP', $this->invoice->pa_cup);
            }
            if ($this->invoice->pa_cig)
            {
                $linea->addChild('CodiceCIG', $this->invoice->pa_cig);
            }
        }
    }


    public function datiBeniServizi($body)
    {
        $DatiBeniServizi = $body->DatiBeniServizi;

        foreach($this->items as $n => $item)
        {
            $descrizione = $item->descrizione;
            if($descrizione == '')
            {
                $descrizione = $item->product->nome;
            }
            $linea = $DatiBeniServizi->addChild('DettaglioLinee');
            $linea->addChild('NumeroLinea', ($n+1));
            $linea->addChild('Descrizione', $descrizione);
            $linea->addChild('Quantita', $this->decimal($item->qta));
            $linea->addChild('PrezzoUnitario', $this->decimal($item->importo));

            if ($item->sconto > 0)
            {
                $scmag = $linea->addChild('ScontoMaggiorazione');
                $scmag->addChild('Tipo', "SC");
                $scmag->addChild('Percentuale', $this->decimal($item->sconto));
            }

            $linea->addChild('PrezzoTotale', $this->decimal($item->totale_riga));
            $linea->addChild('AliquotaIVA', $this->decimal($item->perc_iva));
            if (!is_null($item->exemption_id))
            {
                $linea->addChild('Natura', $item->exemption->codice);
            }

            if( $this->invoice->ritenuta > 0 )
            {
                $linea->addChild('Ritenuta', 'SI');
            }

        }

        foreach ($this->invoice->items_grouped_by_ex as $n => $group)
        {
            $linea = $DatiBeniServizi->addChild('DatiRiepilogo');

            if(is_null($group->exemption_id))
            {
                $linea->addChild('AliquotaIVA', $this->decimal($group->perc_iva));
                $linea->addChild('ImponibileImporto', $this->decimal($group->imponibile));
                $linea->addChild('Imposta', $this->decimal($group->iva));
                $linea->addChild('EsigibilitaIVA', "I");
            }
            else
            {
                $linea->addChild('AliquotaIVA', $this->decimal($group->perc_iva));
                $linea->addChild('Natura', $group->natura);
                $linea->addChild('ImponibileImporto', $this->decimal($group->imponibile));
                $linea->addChild('Imposta', $this->decimal($group->iva));
                $linea->addChild('RiferimentoNormativo', $group->riferimento_normativo);
            }
        }
    }


    public function datiPagamento($body)
    {
        $DatiPagamento = $body->DatiPagamento;
        if($this->invoice->rate)
        {
            //todo
        }
        else
        {
            $DatiPagamento->CondizioniPagamento = 'TP02';
            $linea = $DatiPagamento->addChild('DettaglioPagamento');
            $linea->addChild('ModalitaPagamento', $this->payment_methods[$this->invoice->pagamento]);
            $linea->addChild('DataScadenzaPagamento', $this->invoice->data_scadenza->format('Y-m-d'));
            $linea->addChild('ImportoPagamento', $this->decimal($this->invoice->total));
            if ($this->cedente->IBAN != '')
            {
                $linea->addChild('IBAN', $this->cedente->IBAN);
            }
        }
    }




}
