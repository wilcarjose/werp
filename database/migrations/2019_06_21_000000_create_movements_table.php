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
            $table->uuid('id')->primary();
            $table->string('code');
            $table->timestamp('date');
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->uuid('doctype_id');
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->uuid('warehouse_from_id');
            $table->foreign('warehouse_from_id')
                ->references('id')
                ->on('warehouses');
            $table->uuid('warehouse_to_id');
            $table->foreign('warehouse_to_id')
                ->references('id')
                ->on('warehouses');
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->timestamps();
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
        Schema::dropIfExists('movements');
    }
}
