<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('partner_id')->unsigned();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
                $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
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
        Schema::dropIfExists('partner_category');
    }
}
