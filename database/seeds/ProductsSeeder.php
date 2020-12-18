<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Jacofda\Klaxon\Models\Product;
use Jacofda\Klaxon\Models\Crm\{ProductType, ProductCategory};

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        Product::truncate();
        ProductCategory::truncate();
        ProductType::truncate();
        Schema::enableForeignKeyConstraints();

        $types = ['Vendita', 'Ricambio', 'Ordini'];
        $categories = [
            0 => [
                '1. The KLICK',
                '2. Articoli aggancio carrozzina',
                '3. Adattamenti e facilitazioni di guida',
                '5. Kit di Sicurezza',
                '6. Altri accessori',
                '7. Invisible',
                'Extra'
            ],
            1 => [
                '1. Sistema Di Aggancio',
                '2. Ciclistica',
                '3. Elettronica e Motore',
                '4. Altri accessori'
            ],
            2 => [
                '7. Posizionamento comandi di guida',
                'Accessori',
                'Bracciale',
                'Traverso'
            ]
        ];

        foreach($types as $key => $type)
        {
            ProductType::create(['nome' => $type]);
            foreach($categories[$key] as $category)
            {
                ProductCategory::create([
                    'nome' => $category,
                    'type_id' => $key+1
                ]);
            }
        }
        


        Product::create([
            'codice' => 'AAA',
            'codice_crm' => 'AAA-CRM',
            'nome_it' => 'Prodotto AAA',
            'nome_en' => 'Product AAA',
            'nome_en' => 'Produkte AAA',
            'prezzo_acquisto' => '200.00',
            'type_id' => 1,
            'qta_confezione' => 1,
            'tempo_fornitura' => 60,
            'unita' => 'pz',
            'qta_min' => 10,
            'qta_min_acquisto' => 10,
            'qta_min_magazzino' => 10,
            'company_id' => 1,
            'group_id' => 1
        ]);


        Product::create([
            'codice' => 'AAA1',
            'codice_crm' => 'AAA1-CRM',
            'nome_it' => 'Prodotto AAA1',
            'nome_en' => 'Product AAA1',
            'nome_en' => 'Produkte AAA1',
            'prezzo_acquisto' => '100.00',
            'type_id' => 1,
            'qta_confezione' => 1,
            'tempo_fornitura' => 60,
            'unita' => 'pz',
            'qta_min' => 10,
            'qta_min_acquisto' => 10,
            'qta_min_magazzino' => 10,
            'company_id' => 1,
            'group_id' => 1
        ]);

        Product::create([
            'codice' => 'AAA2',
            'codice_crm' => 'AAA2-CRM',
            'nome_it' => 'Prodotto AAA2',
            'nome_en' => 'Product AAA2',
            'nome_en' => 'Produkte AAA2',
            'prezzo_acquisto' => '50.00',
            'type_id' => 1,
            'qta_confezione' => 1,
            'tempo_fornitura' => 60,
            'unita' => 'pz',
            'qta_min' => 10,
            'qta_min_acquisto' => 10,
            'qta_min_magazzino' => 10,
            'company_id' => 1,
            'group_id' => 1
        ]);

        Product::create([
            'codice' => 'AA3',
            'codice_crm' => 'AA3-CRM',
            'nome_it' => 'Prodotto AA3',
            'nome_en' => 'Product AA3',
            'nome_en' => 'Produkte AA3',
            'prezzo_acquisto' => '20.00',
            'type_id' => 1,
            'qta_confezione' => 1,
            'tempo_fornitura' => 60,
            'unita' => 'pz',
            'qta_min' => 10,
            'qta_min_acquisto' => 10,
            'qta_min_magazzino' => 10,
            'company_id' => 1,
            'group_id' => 1
        ]);

        Product::create([
            'codice' => 'BBB',
            'codice_crm' => 'BBB-CRM',
            'nome_it' => 'Prodotto BBB',
            'nome_en' => 'Product BBB',
            'nome_en' => 'Produkte BBB',
            'prezzo_acquisto' => '500.00',
            'type_id' => 1,
            'qta_confezione' => 1,
            'tempo_fornitura' => 60,
            'unita' => 'pz',
            'qta_min' => 10,
            'qta_min_acquisto' => 10,
            'qta_min_magazzino' => 10,
            'company_id' => 1,
            'group_id' => 1
        ]);





    }
}
