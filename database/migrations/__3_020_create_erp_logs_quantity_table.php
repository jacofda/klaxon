<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpLogsQuantityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_logs_quantity', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('before')->unsigned()->default(0);
            $table->smallInteger('after')->unsigned()->default(0);
            $table->smallInteger('qta')->default(0);
            $table->integer('from_company_id')->nullable()->unsigned();
            $table->foreign('from_company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('to_company_id')->unsigned();
            $table->foreign('to_company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('erp_orders')->onDelete('cascade');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('erp_logs_quantity');
    }
}
