<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference');
            $table->string('counting_number'); // it can be counted many time by many people
            $table->timestamp('date');
            $table->timestamp('counting_date')->nullable();
            $table->text('description')->nullable();
            $table->double('qty')->default(0);
            $table->double('current_qty')->default(0);
            $table->double('variance_qty')->default(0);
            $table->double('variance_percent')->nullable(0);
            $table->text('deviation_level')->nullable();
            $table->enum('main',['y', 'n'])->default('y');
            $table->uuid('inventory_id');
            $table->foreign('inventory_id')
                ->references('id')
                ->on('inventories');
            $table->uuid('counter_id')->nullable();
            $table->foreign('counter_id')
                ->references('id')
                ->on('partners');
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
        Schema::dropIfExists('inventory_lines');
    }
}
