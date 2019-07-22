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
            $table->increments('id');
            $table->double('amount_from');
            $table->double('amount_to');
            $table->integer('uom_from_id')->unsigned();
            $table->foreign('uom_from_id')
                ->references('id')
                ->on('uom');
            $table->integer('uom_to_id')->unsigned();
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
