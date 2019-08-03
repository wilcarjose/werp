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
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->string('alternate_code')->nullable();
            $table->string('part_number')->nullable();
            $table->text('description')->nullable();
            $table->string('barcode')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('link')->nullable();
            $table->uuid('uom_id')->nullable();
            $table->foreign('uom_id')
                ->references('id')
                ->on('uom');
            $table->uuid('category_id')->nullable();
            $table->string('image')->nullable();
            $table->enum('is_service', ['y','n'])->default('n');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->uuid('brand_id')->nullable();
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands');
            $table->uuid('partner_id')->nullable();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
            $table->enum('status',['active','inactive'])->default('active');
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
        Schema::dropIfExists('products');
    }
}
