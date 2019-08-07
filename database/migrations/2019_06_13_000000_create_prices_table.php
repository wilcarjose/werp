<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Base\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('starting_at');
            $table->double('price', 20, 4)->default(0.0000);
            $table->double('before_price', 20, 4)->nullable();
            $table->double('base_price', 20, 4)->nullable();
            $table->string('operation_name')->nullable();
            $table->string('currency')->default('USD');
            $table->uuid('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->uuid('price_list_id');
            $table->foreign('price_list_id')
                ->references('id')
                ->on('price_lists');
            $table->uuid('price_list_type_id');
            $table->foreign('price_list_type_id')
                ->references('id')
                ->on('price_list_types');
            $table->uuid('amount_operation_id')->nullable();
            $table->foreign('amount_operation_id')
                ->references('id')
                ->on('amount_operations');
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
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
        Schema::dropIfExists('prices');
    }
}
