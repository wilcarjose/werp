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
            $table->increments('id');
            $table->string('code')->unique();
            $table->dateTime('date');
            $table->text('description')->nullable();
            $table->string('alternate_code')->nullable();
            $table->string('reference')->nullable();
            $table->double('amount', 10, 4)->default(0.0000);
            $table->double('tax_amount', 10, 4)->default(0.0000);
            $table->double('discount_amount', 10, 4)->default(0.0000);
            $table->double('total_amount', 10, 4)->default(0.0000);
            $table->string('currency')->default('USD');
            $table->enum('type',[Order::SALE_TYPE, Order::PURCHASE_TYPE])->default(Order::SALE_TYPE);
            $table->enum('is_invoice_pending',['y','n'])->default('y');
            $table->enum('is_delivery_pending',['y','n'])->default('y');
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->integer('partner_id')->unsigned();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
            $table->integer('doctype_id')->unsigned();
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->nullable();
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
        Schema::dropIfExists('orders');
    }
}
