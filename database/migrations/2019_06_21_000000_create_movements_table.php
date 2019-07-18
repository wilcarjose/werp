<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->dateTime('date');
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->integer('doctype_id')->unsigned();
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
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
        Schema::dropIfExists('movements');
    }
}
