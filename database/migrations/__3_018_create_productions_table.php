<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->nullable()->unsigned();
            $table->foreign('order_id')->references('id')->on('erp_orders')->onDelete('cascade');
            $table->integer('input_id')->nullable()->unsigned();
            $table->foreign('input_id')->references('id')->on('products')->onDelete('cascade');
            $table->smallInteger('input_qta')->unsigned()->default(0);
            $table->smallInteger('input_qta_sent')->unsigned()->default(0);
            $table->integer('input_company_id')->nullable()->unsigned();
            $table->foreign('input_company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('work_id')->nullable()->unsigned();
            $table->foreign('work_id')->references('id')->on('works')->onDelete('cascade');
            $table->integer('output_id')->nullable()->unsigned();
            $table->foreign('output_id')->references('id')->on('products')->onDelete('cascade');
            $table->smallInteger('output_qta')->unsigned()->default(0);
            $table->smallInteger('status')->unsigned()->default(0);
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
        Schema::dropIfExists('productions');
    }
}
