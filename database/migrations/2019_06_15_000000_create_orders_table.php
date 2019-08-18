<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Products\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->timestamp('date');
            $table->text('description')->nullable();
            $table->string('alternate_code')->nullable();
            $table->string('reference')->nullable();
            $table->double('total_price', 20, 4)->default(0.0000);
            $table->double('total_tax', 20, 4)->default(0.0000);
            $table->double('total_discount', 20, 4)->default(0.0000);
            $table->double('total', 20, 4)->default(0.0000);
            $table->uuid('currency_id');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies');
            $table->enum('type',[Order::SALE_TYPE, Order::PURCHASE_TYPE])->default(Order::SALE_TYPE);
            $table->enum('is_invoice_pending',['y','n'])->default('y');
            $table->enum('is_delivery_pending',['y','n'])->default('y');
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->uuid('partner_id');
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
            $table->uuid('doctype_id');
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->uuid('warehouse_id')->nullable();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
            $table->uuid('price_list_type_id');
            $table->foreign('price_list_type_id')
                ->references('id')
                ->on('price_list_types');
            $table->uuid('sale_channel_id')->nullable();
            $table->foreign('sale_channel_id')
                ->references('id')
                ->on('sales_channels');
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
        Schema::dropIfExists('orders');
    }
}
