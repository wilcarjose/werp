<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Maintenance\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->string('control_number')->nullable();
            $table->string('order_code')->nullable();
            $table->timestamp('date');
            $table->text('description')->nullable();
            $table->string('alternate_code')->nullable();
            $table->string('reference')->nullable();
            $table->double('total_price', 20, 4)->default(0.0000);
            $table->double('total_tax', 20, 4)->default(0.0000);
            $table->double('total_discount', 20, 4)->default(0.0000);
            $table->double('total', 20, 4)->default(0.0000);
            $table->double('total_paid', 20, 4)->default(0.0000);
            $table->enum('paid',['y','n'])->default('n');
            $table->uuid('currency_id');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies');
            $table->enum('type',[Invoice::SALE_TYPE, Invoice::PURCHASE_TYPE])->default(Invoice::SALE_TYPE);
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->uuid('partner_id');
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
            $table->uuid('doctype_id');
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->uuid('price_list_type_id');
            $table->foreign('price_list_type_id')
                ->references('id')
                ->on('price_list_types');
            $table->uuid('order_id')->nullable();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
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
            $table->uuid('payment_method_id')->nullable();
            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods');
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
        Schema::dropIfExists('invoices');
    }
}
