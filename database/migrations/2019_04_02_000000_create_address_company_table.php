<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_company', function (Blueprint $table) {
            $table->uuid('address_id');
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
            $table->uuid('company_id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
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
        Schema::dropIfExists('address_company');
    }
}
