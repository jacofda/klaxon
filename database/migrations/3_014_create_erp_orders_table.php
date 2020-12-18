<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment');
            $table->smallInteger('status')->default(0);
            $table->string('type')->nullable();
            $table->string('notes')->nullable();
            $table->string('color', 15)->nullable()->default('transparent');
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
        Schema::dropIfExists('erp_orders');
    }
}
