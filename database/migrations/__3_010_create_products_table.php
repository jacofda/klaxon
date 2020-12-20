<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codice', 50)->nullable();
            $table->string('codice_crm', 50)->nullable();
            $table->string('codice_fornitore', 50)->nullable();
            $table->string('nome_it')->nullable();
            $table->string('nome_en')->nullable();
            $table->string('nome_de')->nullable();
            $table->text('descrizione_it')->nullable();
            $table->text('descrizione_en')->nullable();
            $table->text('descrizione_de')->nullable();
            $table->string('versione', 8)->nullable();
            $table->float('prezzo_acquisto', 8, 4)->nullable();
            $table->float('prezzo_retail', 8, 4)->nullable();
            $table->float('prezzo_standard', 8, 4)->nullable();
            $table->integer('type_id')->nullable()->unsigned();
            $table->foreign('type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->integer('category_id')->nullable()->unsigned();
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->boolean('active')->default(true);
            // erp
            $table->boolean('acquistabile')->default(true);
            $table->boolean('has_sn')->default(false);
            $table->smallInteger('qta_confezione')->unsigned()->nullable();
            $table->smallInteger('tempo_fornitura')->unsigned()->nullable();
            $table->float('costo_fornitura', 8, 4)->nullable();
            $table->string('unita', 3)->nullable();
            $table->smallInteger('qta_min')->unsigned()->nullable();
            $table->smallInteger('qta_min_acquisto')->unsigned()->nullable();
            $table->smallInteger('qta_min_magazzino')->unsigned()->nullable();
            $table->integer('company_id')->nullable()->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('group_id')->nullable()->unsigned();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
