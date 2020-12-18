<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Jacofda\Klaxon\Models\Crm\Group;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        Group::truncate();
        Schema::enableForeignKeyConstraints();

        $groups = [
          'HUB-MOTORE',
          'HUB-CENTRALINA',
          'HUB-DISPLAY',
          'HUB-RETROMARCIA',
          'HUB-ACCELERATORE',
          'HUB-BATTERIA',
          'HUB-CARICABATTERIA',
          'HUB-LEVE FRENO',
          'HUB-CABLAGGIO',
          'HUB-MANUBRIO',
          'HUB-CANNOTTO',
          'HUB-SUPPORTO BATTERIA',
          'HUB-PIASTRA FISSAGGIO',
          'HUB-FORCELLA',
          'HUB-FRENO',
          'HUB-CAVALLETTO',
          'HUB-RUOTA',
          'HUB-TUBO TELESCOPICO',
          'HUB-COVER',
          'HUB-CAMBIO - CATENA',
          'OPT-LUCI',
          'VIT-VITERIA',
          'LNK-AGGANCIO BRACCIALE',
          'LNK-AGGANCIO LONGHERONE',
          'LNK-AGGANCIO TRAVERSO',
          'OPT-ACCESSORIO BATTERIA',
          'OPT-ACCESSORIO GUIDA',
          'OPT-ACCESSORIO CICLISTICA',
          'OPT-KIT SICUREZZA',
          'RIPARAZIONI KLAXON',
          'PROTO-CAMPIONATURE',
          'HUB-KIT ASSEMBLAGGIO',
          'HUB-KLICK PREASSEMBLATO',
          'LNK-KIT AGGANCIO CARROZZINA',
          'OPT-ALTRI ACCESSORI',
          'IMB-IMBALLAGGI',
          'HUB-SPEDIZIONE',
          'HUB-OEM1-CABLAGGIO',
          'HUB-OEM1-DISPLAY',
          'HUB-OEM1-FORCELLA',
          'HUB-OEM1-SUPPORTO BATTERIA',
          'HUB-OEM1-PIASTRA FISSAGGIO',
          'HUB-OEM1-MOTORE',
          'HUB-OEM!-CANNOTTO',
          'HUB-OEM1-CAVALLETTO',
          'HUB-OEM1-IMBALLAGGI',
          'HUB-AGGANCIO LATERALE',
          'HUB-K1-MOTORE'
        ];

        foreach($groups as $group)
        {
            Group::create(['nome' => $group]);
        }

    }
}
