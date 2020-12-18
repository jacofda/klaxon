<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Jacofda\Klaxon\Models\Product;
use Jacofda\Klaxon\Models\Crm\Supplier;
use Jacofda\Klaxon\Models\Sector;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = [
            "01" => "Parti, Componenti prodotti, Utensileria e Attrezzature",
            "02" => "Lavorazioni di componenti",
            "03" => "Utenze (telefoni, internet, servizi elettricità)",
            "04" => "Trasporti, Logistica",
            "05" => "Imballaggi",
            "06" => "Consulenza Marketing",
            "07" => "Consulenza Tecnologica",
            "08" => "Consulenza Gestionale",
            "09" => "Consulenza IT + WEB",
            "10" => "Consulenza Legale",
            "11" => "Consulenza Amministrativa e Fiscale",
            "12" => "Ristoranti, Hotel, Viaggi",
            "13" => "Auto, Carburanti, Manutenzione",
            "14" => "Assicurazioni",
            "15" => "Cancelleria",
            "16" => "Attrezzature Elettroniche e Mobili Ufficio",
            "17" => "Certificazioni Prodotti e Qualità",
            "18" => "Altri Fornitori",
            "19" => "Software",
            "20" => "Partner, Magazzini interni, dipendenti",
            "21" => "Listini Prezzi",
            "22" => "Consulenza Vendite"
        ];

        $sector = [
            'Distributor',
            'Shop',
            'Private',
            'O.E.M.',
            'Service/Consultant'
        ];

        foreach($sector as $s)
        {
            Sector::create(['nome' => $s]);
        }

        foreach($arr as $codice => $nome)
        {
            Supplier::create([
                'nome' => $nome,
                'codice' => $codice
            ]);
        }

    }
}
