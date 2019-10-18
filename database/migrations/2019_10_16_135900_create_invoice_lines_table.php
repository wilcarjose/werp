<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_lines', function (Blueprint $table) {
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
            $table->uuid('currency_id');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies');
            $table->double('qty');
            $table->uuid('invoice_id');
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices');
            $table->uuid('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->uuid('tax_id')->nullable();
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxs_discounts');
            $table->uuid('discount_id')->nullable();
            $table->foreign('discount_id')
                ->references('id')
                ->on('taxs_discounts');
            $table->uuid('price_id')->nullable();
            $table->foreign('price_id')
                ->references('id')
                ->on('prices');
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->uuid('order_line_id')->nullable();
            $table->foreign('order_line_id')
                ->references('id')
                ->on('order_lines');
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
        Schema::dropIfExists('invoice_lines');
    }
}
