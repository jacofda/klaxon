<?php

use Illuminate\Database\Seeder;
use Jacofda\Klaxon\Models\Exemption;
use Illuminate\Support\Facades\Schema;

class ExemptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        Exemption::truncate();
        Schema::enableForeignKeyConstraints();

        Exemption::create([
            'nome' => "Delivery in Austria",
            'perc' => 20,
            'def' => 0
        ]);

        Exemption::create([
            'nome' => "Tax-free intra-Community triangular business (Art 25 &ouml;UStG). Reverse charge",
            'perc' => 0,
            'def' => 0
        ]);

        Exemption::create([
            'nome' => "Tax-exempt intra-Community delivery (Art 6 and 7 öUStG)",
            'perc' => 0,
            'def' => 1
        ]);

        Exemption::create([
            'nome' => "Tax-free export delivery (§ 6 Abs 1 Z 1 e &sect; 7 öUStG)",
            'perc' => 0,
            'def' => 0
        ]);

        Exemption::create([
            'nome' => "Reverse Charge",
            'perc' => 0,
            'def' => 0
        ]);


    }
}
