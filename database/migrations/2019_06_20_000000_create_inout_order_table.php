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
            //$table->uuid('id')->primary();
            $table->uuid('inout_id');
            $table->foreign('inout_id')
                ->references('id')
                ->on('inouts');
            $table->uuid('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
            $table->softDeletes();
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
