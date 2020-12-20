<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};
use Illuminate\Support\Facades\Schema;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {

         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         $super = Role::create(['name' => 'super']);
         //
         $crm = Role::create(['name' => 'crm']);
         $erp = Role::create(['name' => 'erp']);

         $actions = ['*','read','write','delete'];
         $models = [
                'companies',
                'contacts',
                'invoices',
                'costs',
                'products',
                'productsERP',
                'productsCRM',
                'stores',
                'oredersERP',
                'expenses',
                'stas',
                'lists',
                'templates',
                'newsletters',
                'users',
                'roles',
                'works',
                'suppliers',
                'groups',
                'pricelists',
                'productions',
                'assemblies'
            ];

         foreach($models as $model)
         {
             foreach($actions as $action)
             {
                 Permission::create(['name' => $model.'.'.$action]);
             }
         }

     }
}
