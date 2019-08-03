<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Base\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;

class CreateAmountOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amount_operations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('operation')->nullable();
            $table->double('value', 8, 2)->nullable();
            $table->string('config_key')->nullable();
            $table->string('round')->default(0);
            $table->string('type')->nullable();
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
        Schema::dropIfExists('amount_operations');
    }
}
