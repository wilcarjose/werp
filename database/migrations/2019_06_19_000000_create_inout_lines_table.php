<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInoutLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inout_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('date');
            $table->string('reference');
            $table->double('price', 20, 4)->default(0.0000);
            $table->double('tax', 20, 4)->default(0.0000);
            $table->double('discount', 20, 4)->default(0.0000);
            $table->double('full_price', 20, 4)->default(0.0000);
            $table->double('total_price', 20, 4)->default(0.0000);
            $table->double('total_tax', 20, 4)->default(0.0000);
            $table->double('total_discount', 20, 4)->default(0.0000);
            $table->double('total', 20, 4)->default(0.0000);
            $table->uuid('currency_id')->nullable();
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies');
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
            $table->uuid('order_line_id')->nullable();
            $table->foreign('order_line_id')
                ->references('id')
                ->on('order_lines');
            $table->uuid('tax_id')->nullable();
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxs_discounts');
            $table->uuid('discount_id')->nullable();
            $table->foreign('discount_id')
                ->references('id')
                ->on('taxs_discounts');
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
        Schema::dropIfExists('inout_lines');
    }
}
