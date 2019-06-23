<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_partner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
                $table->integer('partner_id')->unsigned();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
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
        Schema::dropIfExists('product_partner');
    }
}
