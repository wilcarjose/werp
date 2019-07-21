<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInoutOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inout_order', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('inout_id')->unsigned();
            $table->foreign('inout_id')
                ->references('id')
                ->on('inouts');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inout_order');
    }
}
