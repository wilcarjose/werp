<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUomConversionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uom_conversion', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->double('amount_from');
            $table->double('amount_to');
            $table->uuid('uom_from_id');
            $table->foreign('uom_from_id')
                ->references('id')
                ->on('uom');
            $table->uuid('uom_to_id');
            $table->foreign('uom_to_id')
                ->references('id')
                ->on('uom');
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
        Schema::dropIfExists('uom_conversion');
    }
}
