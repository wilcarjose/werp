<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Base\Models\BaseModel;
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
            $table->uuid('id')->primary();
            $table->string('name');
            $table->uuid('basedoc_id');
            $table->foreign('basedoc_id')
                ->references('id')
                ->on('basedocs');
            $table->string('prefix')->nullable();
            $table->integer('increment_number')->default(1);
            $table->integer('last_number')->default(0);
            $table->enum('use_zeros',['y','n'])->default('y');
            $table->integer('number_long')->default(3);
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
        Schema::dropIfExists('doctypes');
    }
}
