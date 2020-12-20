<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpOrderChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_order_checklist', function (Blueprint $table) {
            $table->integer('erp_order_id')->nullable()->unsigned();
            $table->foreign('erp_order_id')->references('id')->on('erp_orders')->onDelete('cascade');
            $table->integer('check_id')->nullable()->unsigned();
            $table->foreign('check_id')->references('id')->on('checks')->onDelete('cascade');
            $table->boolean('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_order_checklist');
    }
}
