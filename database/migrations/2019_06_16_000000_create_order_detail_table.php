<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->string('reference');
            $table->double('amount', 10, 4)->default(0.0000);
            $table->double('tax_amount', 10, 4)->default(0.0000);
            $table->double('discount_amount', 10, 4)->default(0.0000);
            $table->double('total_amount', 10, 4)->default(0.0000);
            $table->string('currency')->default('USD');
            $table->double('qty');
            $table->double('qty_delivered')->default(0);
            $table->double('qty_invoiced')->default(0);
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')
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
        Schema::dropIfExists('order_detail');
    }
}
