<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};
use App\User;
use Illuminate\Support\Facades\Schema;
use Jacofda\Klaxon\Models\{Calendar, Category, Client, Contact, Company, Expense, Product, NewsletterList, Template};

class StarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {

         Schema::disableForeignKeyConstraints();
         Company::truncate();
         Contact::truncate();
         User::truncate();
         Client::truncate();
         Calendar::truncate();
         NewsletterList::truncate();
         Schema::enableForeignKeyConstraints();


         Company::create(['rag_soc' => 'Magazzino', 'fornitore' => 1, 'note' => 'Magazzino 0 ERP']);
         Company::create(['rag_soc' => 'Ricambi', 'fornitore' => 1, 'note' => 'Magazzino 1 Ricambi ERP']);
         Company::create(['rag_soc' => 'Finiti', 'fornitore' => 1, 'note' => 'Magazzino 31 Finiti ERP']);
         Company::create(['rag_soc' => 'Spedizione', 'fornitore' => 1, 'note' => 'Magazzino 228 Spedizioni ERP']);

         $super = Role::find(1);

         Client::create(['nome' => 'Prospect', 'contact' => 1, 'company' => 1]);
         Client::create(['nome' => 'Lead', 'contact' => 1, 'company' => 1]);
         Client::create(['nome' => 'Client', 'contact' => 1, 'company' => 1]);
         Client::create(['nome' => 'Referente', 'contact' => 0, 'company' => 1]);


         $client = Client::Client()->id;

         $user = User::create([
             'email' => 'giacomo.gasperini@gmail.com',
             'password' => bcrypt('83674trf%*9op[]')
         ]);

         $user->roles()->attach($super);

         $company = Company::create([
             'rag_soc' => 'Areaseb SRL',
             'indirizzo' => 'Vicolo Don Luigi Soldá 5/8',
             'cap' => '36061',
             'citta' => 'Bassano del Grappa',
             'provincia' => 'Vicenza',
             'piva' => '04110830249',
             'partner' => 1,
             'telefono' => '+390424500994',
             'email' => 'info@areaseb.it',
         ]);

         $company->clients()->attach($client);

         $contact = Contact::create([
             'nome' => 'Giacomo',
             'cognome' => 'Gasperini',
             'cellulare' => '+393421967852',
             'email' => 'giacomo.gasperini@areaseb.it',
             'indirizzo' => 'Fraz Martincelli',
             'cap' => '38055',
             'citta' => 'Grino',
             'provincia' => 'Trento',
             'user_id' => $user->id,
             'company_id' => $company->id,
         ]);

         $contact->clients()->attach($client);


         $uk = User::create([
             'email' => 'admin@klaxon.com',
             'password' => bcrypt('admin')
         ]);

         $uk->roles()->attach($super);

         $ck = Company::create([
             'rag_soc' => 'Klaxon Mobility GmbH',
             'indirizzo' => 'Industriestrasse 1',
             'cap' => '9601',
             'citta' => 'Arnoldstein',
             'provincia' => null,
             'nazione' => 'AT',
             'telefono' => '+436644681294',
             'email' => 'info@klaxon-klick.com ',
         ]);

         $cck = Contact::create([
             'nome' => 'Enrico',
             'cognome' => 'Boaretto',
             'cellulare' => '+436643806856',
             'email' => 'e.boaretto@klaxon-klick.com',
             'user_id' => $uk->id,
             'company_id' => $ck->id,
         ]);

         $cck->clients()->attach($client);

         Calendar::create(['user_id' => $user->id]);
         Calendar::create(['user_id' => $uk->id]);

         Template::create(['nome' => 'Default']);

         NewsletterList::create(['nome' => 'Tutti']);

     }
}
