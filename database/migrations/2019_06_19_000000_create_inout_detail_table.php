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
            $table->uuid('inout_id');
            $table->foreign('inout_id')
                ->references('id')
                ->on('inouts');
            $table->uuid('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
            $table->uuid('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->uuid('order_detail_id')->nullable();
            $table->foreign('order_detail_id')
                ->references('id')
                ->on('order_detail');
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
        Schema::dropIfExists('inout_detail');
    }
}
