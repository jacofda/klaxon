<?php

use Illuminate\Database\Seeder;
use Jacofda\Klaxon\Models\DeliveryCompany;
use Illuminate\Support\Facades\Schema;

class DeliveryCompanysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DeliveryCompany::truncate();
        Schema::enableForeignKeyConstraints();

        $arr = [
            'TNT',
            'UPS',
            'GLS',
            'DB Schenker',
            'Post AG',
            'DHL',
            'DPD',
            'FEDEX',
            'Klaxon Mobility GmbH',
            'CARGOMIND',
            'BRT Bartolini',
            'TWW - Team Worldwide',
            'Maurice Ward Group',
            'TREU Spedizioni',
            'MATFIL PL',
            'Kuehne + Nagel'
        ];

        foreach($arr as $value)
        {
            DeliveryCompany::create([
                'nome' => $value,
            ]);
        }


    }
}
