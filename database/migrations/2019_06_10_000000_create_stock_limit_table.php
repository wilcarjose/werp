<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockLimitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_limit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('product_id')->unsigned();
            $table->double('max_qty');
            $table->double('min_qty')->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->integer('warehouse_id')->unsigned()->nullable();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
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
        Schema::dropIfExists('stock_limit');
    }
}
