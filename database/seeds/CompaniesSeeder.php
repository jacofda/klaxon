<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Jacofda\Klaxon\Models\Company;

class CompaniesSeeder extends Seeder
{

    public function run()
    {
        $aziende = [
            [
                'old_id' => '222',
                'rag_soc' => 'PROFLINE S.R.L.',
                'indirizzo' => 'Via F. Baracca, 71/A',
                'cap' => '31010',
                'citta' => 'CIMADOLMO',
                'provincia' => 'TV',
                'nazione' => 'IT',
                'piva' => '',
                'cf' => '',
                'fornitore' => 1,
                'partner' => 0,
                'telefono' => '+39 0422803417',
                'email' => 'info@profline.it',
                'email_ordini' => 'andrea.giacomini@profline.it',
                'email_fatture' => '',
                'attivo' => 1,
                'numero' => '01.039',
                'lingua' => 'it',
                'pricelist_id' => NULL,
                'valuta' => 'EUR',
                'supplier_id' => 1,
                'pagamento' => 'BO6D'
            ],


          [
            'old_id' => '354',
            'rag_soc' => 'OTTO BOCK MOBILITY SOLUTIONS GMBH',
            'indirizzo' => 'Prenzlauer 242, Haus 3',
            'cap' => '10405',
            'citta' => 'Berlin',
            'provincia' => null,
            'nazione' => 'DE',
            'piva' => null,
            'cf' => null,
            'fornitore' => 0,
            'partner' => 0,
            'telefono' => null,
            'email' => 'ilona.wiemann@ottobock.com',
            'email_ordini' => null,
            'email_fatture' => '',
            'attivo' => 1,
            'numero' => 'DE.D02',
            'lingua' => 'de',
            'pricelist_id' => null,
            'valuta' => 'EUR',
            'sector_id' => 1
          ],
          [
            'old_id' => '228',
            'rag_soc' => 'V!GO N.V. / S.A.',
            'indirizzo' => 'Biezeweg 13',
            'cap' => '9230',
            'citta' => 'Wetteren',
            'provincia' => 'BE',
            'nazione' => 'BE',
            'piva' => 'BE0444471717',
            'cf' => null,
            'fornitore' => 0,
            'partner' => 0,
            'telefono' => null,
            'email' => 'info@vigogroup.eu',
            'email_ordini' => 'aankoop-004@vigogroup.eu',
            'email_fatture' => 'invoice.receipt-be100@vigogroup.eu',
            'attivo' => 1,
            'numero' => 'BE.S01',
            'lingua' => 'en',
            'pricelist_id' => null,
            'valuta' => 'EUR',
            'sector_id' => 2
          ],
          [
            'old_id' => '447',
            'rag_soc' => 'DOMINIC COLEMAN',
            'indirizzo' => '29 Chauncey Close',
            'cap' => 'N9 9SE',
            'citta' => 'London',
            'provincia' => null,
            'nazione' => 'UK',
            'piva' => null,
            'cf' => null,
            'fornitore' => 0,
            'partner' => 0,
            'telefono' => '+44 7447499978',
            'email' => 'domjcoleman@hotmail.com',
            'email_ordini' => 'domjcoleman@hotmail.com',
            'email_fatture' => 'domjcoleman@hotmail.com',
            'attivo' => 1,
            'numero' => 'UK.P02',
            'lingua' => 'en',
            'pricelist_id' => null,
            'valuta' => 'EUR',
            'sector_id' => 3
          ],
          [
            'old_id' => '152',
            'rag_soc' => 'MOTION COMPOSITES INC',
            'indirizzo' => '160, Ru Armand-Majeau Sud Saint-Roch-de-l&#039;Achigan',
            'cap' => 'J0K 3H0',
            'citta' => 'Qu&eacute;bec, Canada',
            'provincia' => 'CA',
            'nazione' => 'CA',
            'piva' => '371770188',
            'cf' => null,
            'fornitore' => 0,
            'partner' => 0,
            'telefono' => null,
            'email' => null,
            'email_ordini' => 'purchaseorder@motioncomposites.com, m.aguilar@motioncomposites.com',
            'email_fatture' => 'payables@motioncomposites.com',
            'attivo' => 1,
            'numero' => 'CA.D01',
            'lingua' => 'en',
            'pricelist_id' => null,
            'valuta' => 'USD',
            'sector_id' => 1
          ],
          [
            'old_id' => '255',
            'rag_soc' => 'WOLTURNUS GMBH',
            'indirizzo' => 'Alter Kirchenweg 87',
            'cap' => '24983',
            'citta' => 'Handewitt',
            'provincia' => 'DE',
            'nazione' => 'DE',
            'piva' => 'DE286880135',
            'cf' => null,
            'fornitore' => 0,
            'partner' => 0,
            'telefono' => '+49222185313',
            'email' => 'jwa@wolturnus.de',
            'email_ordini' => 'tgo@wolturnus.dk, jga@wolturnus.dk, jwa@wolturnus.de',
            'email_fatture' => 'faktura@wolturnus.dk',
            'attivo' => 1,
            'numero' => 'DE.D01',
            'lingua' => 'de',
            'pricelist_id' => null,
            'valuta' => 'EUR',
            'sector_id' => 1
          ]
        ];

        $count = 0;
        foreach($aziende as $company)
        {

            $c = Company::create($company);
            if($count == 0)
            {
                $c->clients()->attach(1);
            }
            else
            {
                $c->clients()->attach(3);
            }
            $count++;
        }


    }

}
