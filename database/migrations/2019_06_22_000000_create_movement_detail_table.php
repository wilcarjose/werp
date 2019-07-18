<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->string('reference');
            $table->double('qty');
            $table->integer('movement_id')->unsigned();
            $table->foreign('movement_id')
                ->references('id')
                ->on('movements');
            $table->integer('warehouse_from_id')->unsigned();
            $table->foreign('warehouse_from_id')
                ->references('id')
                ->on('warehouses');
            $table->integer('warehouse_to_id')->unsigned();
            $table->foreign('warehouse_to_id')
                ->references('id')
                ->on('warehouses');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
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
        Schema::dropIfExists('movement_detail');
    }
}
