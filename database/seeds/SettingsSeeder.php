<?php

use Illuminate\Database\Seeder;
use Jacofda\Klaxon\Models\Setting;
use Illuminate\Support\Facades\Schema;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {

         Schema::disableForeignKeyConstraints();
         Setting::truncate();
         Schema::enableForeignKeyConstraints();

         $fields = [
             0 => [
                "MAIL_AUTH" => "Sì",
                "MAIL_HOST" => "",
             	"MAIL_PORT" => "",
             	"MAIL_USERNAME" => "",
             	"MAIL_PASSWORD" => "",
             	"MAIL_ENCRYPTION" => "",
             	"MAIL_FROM_ADDRESS" => "",
             	"MAIL_FROM_NAME" => ""
             ],
             1 => [
                "MAIL_AUTH" => "Sì",
             	"MAIL_HOST" => "",
             	"MAIL_PORT" => "",
             	"MAIL_USERNAME" => "",
             	"MAIL_PASSWORD" => "",
             	"MAIL_ENCRYPTION" => "",
             	"MAIL_FROM_ADDRESS" => "",
             	"MAIL_FROM_NAME" => ""
             ],
             2 => [
                "MAIL_AUTH" => "Sì",
             	"MAIL_HOST" => "",
             	"MAIL_PORT" => "",
             	"MAIL_USERNAME" => "",
             	"MAIL_PASSWORD" => "",
             	"MAIL_ENCRYPTION" => "",
             	"MAIL_FROM_ADDRESS" => "",
             	"MAIL_FROM_NAME" => ""
             ]
         ];

         Setting::create(['model' => 'SMTP', 'fields' => $fields]);


         $base = [
             "rag_soc"=>"KLAXON MOBILITY GmbH",
            "indirizzo"=>"Industriestrasse, 1",
            "cap"=>"9601",
            "provincia"=>"",
            "citta"=>"Arnoldstein",
            "nazione"=>"AT",
            "piva"=>"ATU69961437",
            "cod_fiscale"=>"",
            'IBAN' => "AT 35 1200 0100 2756 1074",
            'SWIFT' => "BKAUATWW",
            "telefono"=>"+4306644681294",
            "email"=>"info@klaxon-klick.com ",
            "sitoweb"=>"klaxon-klick.com",
            "default_color"=>"#000000",
            "logo_img"=>"",
            "logo_fattura_img"=>"",
            "footer_img"=>""
        ];

        Setting::create(['model' => 'Base', 'fields' => $base]);


        $personale = [
            'Technical Office' => [
                0 => [
                    'nome' => "Antonio Benedini",
                    'email' => "a.benedini@klaxon-klick.com"
                ],
                1 => [
                    'nome' => "Cristian Vidoni",
                    'email' => "c.vidoni@klaxon-klick.com"
                ]
            ],
            'Administration' => [
                0 => [
                    'nome' => "Katia Balsamo",
                    'email' => "k.balsamo@klaxon-klick.com"
                ]
            ]
       ];

       Setting::create(['model' => 'Personale', 'fields' => $personale]);

     }
}
