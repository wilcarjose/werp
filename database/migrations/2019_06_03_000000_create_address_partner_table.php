<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_partner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('partner_id')->unsigned();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
                $table->integer('address_id')->unsigned();
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
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
        Schema::dropIfExists('address_partner');
    }
}
