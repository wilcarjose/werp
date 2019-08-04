<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference');
            $table->timestamp('date');
            $table->text('description')->nullable();
            $table->double('qty');
            $table->uuid('inventory_id');
            $table->foreign('inventory_id')
                ->references('id')
                ->on('inventories');
            $table->uuid('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->uuid('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
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
        Schema::dropIfExists('inventory_detail');
    }
}
