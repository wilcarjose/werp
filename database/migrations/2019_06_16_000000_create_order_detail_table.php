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
            $table->uuid('id')->primary();
            $table->timestamp('date');
            $table->string('reference');
            $table->double('price', 10, 4)->default(0.0000);
            $table->double('tax', 10, 4)->default(0.0000);
            $table->double('discount', 10, 4)->default(0.0000);
            $table->double('full_price', 10, 4)->default(0.0000);
            $table->double('total_price', 10, 4)->default(0.0000);
            $table->double('total_tax', 10, 4)->default(0.0000);
            $table->double('total_discount', 10, 4)->default(0.0000);
            $table->double('total', 10, 4)->default(0.0000);
            $table->string('currency')->default('USD');
            $table->double('qty');
            $table->double('qty_delivered')->default(0);
            $table->double('qty_invoiced')->default(0);
            $table->uuid('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
            $table->uuid('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
            $table->uuid('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->uuid('tax_id')->nullable();
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxs');
            $table->uuid('discount_id')->nullable();
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts');
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->timestamps();
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
        Schema::dropIfExists('order_detail');
    }
}
