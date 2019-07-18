<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('alternate_code')->nullable();
            $table->string('part_number')->nullable();
            $table->text('description')->nullable();
            $table->string('barcode')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('link')->nullable();
            $table->string('uom')->default('unit');
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->enum('is_service', ['y','n'])->default('n');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->integer('brand_id')->unsigned()->nullable();
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands');
            $table->integer('partner_id')->unsigned()->nullable();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
            $table->enum('status',['active','inactive'])->default('active');
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
        Schema::dropIfExists('products');
    }
}
