<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->dateTime('starting_at');
            $table->text('description')->nullable();
            $table->integer('price_list_type_id')->unsigned();
            $table->foreign('price_list_type_id')
                ->references('id')
                ->on('price_list_types');
            $table->integer('doctype_id')->unsigned();
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->integer('reference_price_list_type_id')->unsigned()->nullable();
            $table->foreign('reference_price_list_type_id')
                ->references('id')
                ->on('price_list_types');
            $table->string('state', 2)->default('pe');
            $table->string('operation')->nullable();
            $table->double('reference', 8, 2)->nullable();
            $table->string('round')->default(0); // d-2 down decimales | l-3 low
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
        Schema::dropIfExists('price_lists');
    }
}
