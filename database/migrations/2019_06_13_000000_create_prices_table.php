<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('starting_at');
            $table->double('price', 10, 4)->default(0.0000);
            $table->string('currency')->default('USD');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->integer('price_list_id')->unsigned();
            $table->foreign('price_list_id')
                ->references('id')
                ->on('price_lists');
            $table->integer('price_list_type_id')->unsigned();
            $table->foreign('price_list_type_id')
                ->references('id')
                ->on('price_list_types');
            $table->enum('status',['active','inactive'])->default('active');
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
        Schema::dropIfExists('prices');
    }
}
