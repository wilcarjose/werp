<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Base\Models\BaseModel;
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
            $table->uuid('id')->primary();
            $table->double('amount_from');
            $table->double('amount_to');
            $table->double('conversion_factor')->nullable();
            $table->uuid('uom_from_id');
            $table->foreign('uom_from_id')
                ->references('id')
                ->on('uom');
            $table->uuid('uom_to_id');
            $table->foreign('uom_to_id')
                ->references('id')
                ->on('uom');
            $table->enum('active',[BaseModel::STATUS_ACTIVE, BaseModel::STATUS_INACTIVE])->default(BaseModel::STATUS_ACTIVE);
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
        Schema::dropIfExists('uom_conversion');
    }
}
