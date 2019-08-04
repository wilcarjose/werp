<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInoutOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_company', function (Blueprint $table) {
            $table->uuid('admin_id');
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins');
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
        Schema::dropIfExists('admin_company');
    }
}
