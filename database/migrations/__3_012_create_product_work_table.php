<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_work', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('input_id')->nullable()->unsigned();
            $table->foreign('input_id')->references('id')->on('products')->onDelete('cascade');
            $table->smallInteger('qta')->unsigned()->default(0);
            $table->integer('work_id')->nullable()->unsigned();
            $table->foreign('work_id')->references('id')->on('works')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_work');
    }
}
