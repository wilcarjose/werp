<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceListTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_list_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('currency')->default('USD');
            $table->text('description')->nullable();
            $table->enum('type', ['sales', 'purchases', 'all'])->default('sales');
            $table->enum('status', ['active','inactive'])->default('active');
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
        Schema::dropIfExists('price_list_types');
    }
}
