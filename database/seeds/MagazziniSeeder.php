<?php

use Illuminate\Database\Seeder;
use Jacofda\Klaxon\Models\Company;

class MagazziniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'rag_soc' => 'Magazzino',
            'note' => 'Magzzino 0, interno',
            'fornitore' => 1
        ]);

        Company::create([
            'rag_soc' => 'Ricambi',
            'note' => 'Magzzino Ricambi 1, interno',
            'fornitore' => 1
        ]);

        Company::create([
            'rag_soc' => 'Finiti',
            'note' => 'Magazzino Finiti 31, interno',
            'fornitore' => 1
        ]);

        Company::create([
            'rag_soc' => 'Spedizione',
            'note' => 'Magazzino Spedizioni 228, interno',
            'fornitore' => 1
        ]);

    }
}
