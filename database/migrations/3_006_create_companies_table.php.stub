<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('rag_soc');
            $table->string('indirizzo');
            $table->string('cap')->nullable();
            $table->string('citta')->nullable();
            $table->string('provincia')->nullable();
            $table->char('nazione', 2)->default('IT');
            $table->char('lingua', 2)->default('it');
            $table->char('valuta', 3)->default('EUR');
            $table->boolean('privato')->default(0);

            $table->string('pec')->nullable();
            $table->string('piva')->nullable();
            $table->string('cf')->nullable();

            $table->boolean('fornitore')->default(0);
            $table->boolean('partner')->default(0);
            $table->boolean('attivo')->default(1);
            $table->boolean('spedizione')->default(1);
            $table->string('numero')->nullable();

            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('email_ordini')->nullable();
            $table->string('email_fatture')->nullable();

            $table->integer('parent_id')->nullable();
            $table->text('note')->nullable();

            $table->integer('pricelist_id')->nullable()->unsigned();
            $table->foreign('pricelist_id')->references('id')->on('pricelists')->onDelete('cascade');
            $table->integer('supplier_id')->nullable()->unsigned();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

            $table->integer('sector_id')->nullable()->unsigned();
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');

            $table->integer('pagamento')->nullable();
            $table->integer('old_id')->nullable();

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
        Schema::dropIfExists('companies');
    }
}
