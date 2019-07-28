<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

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
            $table->string('code')->unique();
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
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->integer('amount_operation_id')->unsigned()->nullable();
            $table->foreign('amount_operation_id')
                ->references('id')
                ->on('amount_operations');
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
