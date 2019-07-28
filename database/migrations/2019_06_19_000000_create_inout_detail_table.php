<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInoutDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inout_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->string('reference');
            $table->double('price', 10, 4)->default(0.0000);
            $table->double('amount', 10, 4)->default(0.0000);
            $table->double('tax_amount', 10, 4)->default(0.0000);
            $table->double('discount_amount', 10, 4)->default(0.0000);
            $table->double('total_amount', 10, 4)->default(0.0000);
            $table->string('currency')->default('USD');
            $table->double('qty');
            $table->integer('inout_id')->unsigned();
            $table->foreign('inout_id')
                ->references('id')
                ->on('inouts');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->integer('order_detail_id')->unsigned()->nullable();
            $table->foreign('order_detail_id')
                ->references('id')
                ->on('order_detail');
            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxs');
            $table->integer('discount_id')->unsigned()->nullable();
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts');
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
        Schema::dropIfExists('inout_detail');
    }
}
