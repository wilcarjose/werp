<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Base\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;

class CreateBranchOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_offices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('document')->nullable();
            $table->string('logo')->nullable();
            $table->string('phone1')->nullable();
            $table->uuid('company_id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->uuid('address_id')->nullable();
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
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
        Schema::dropIfExists('branch_offices');
    }
}
