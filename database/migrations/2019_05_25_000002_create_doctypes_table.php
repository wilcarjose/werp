<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('basedoc_id')->unsigned();
            $table->foreign('basedoc_id')
                ->references('id')
                ->on('basedocs');
            $table->string('prefix')->nullable();
            $table->integer('increment_number')->default(1);
            $table->integer('last_number')->default(0);
            $table->enum('use_zeros',['y','n'])->default('y');
            $table->integer('number_long')->default(3);
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
        Schema::dropIfExists('doctypes');
    }
}