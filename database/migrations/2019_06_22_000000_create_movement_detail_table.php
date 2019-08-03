<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('date');
            $table->string('reference');
            $table->double('qty');
            $table->uuid('movement_id');
            $table->foreign('movement_id')
                ->references('id')
                ->on('movements');
            $table->uuid('warehouse_from_id');
            $table->foreign('warehouse_from_id')
                ->references('id')
                ->on('warehouses');
            $table->uuid('warehouse_to_id');
            $table->foreign('warehouse_to_id')
                ->references('id')
                ->on('warehouses');
            $table->uuid('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
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
        Schema::dropIfExists('movement_detail');
    }
}
