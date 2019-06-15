<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference');
            $table->string('type');
            $table->dateTime('date');
            $table->text('description')->nullable();
            $table->double('qty');
            $table->enum('sign',['add','sub'])->default('add');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
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
        Schema::dropIfExists('transactions');
    }
}