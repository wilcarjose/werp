<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
                $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands');
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
        Schema::dropIfExists('product_brand');
    }
}
