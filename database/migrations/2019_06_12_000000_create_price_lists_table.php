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
            $table->uuid('id')->primary();
            $table->string('code');
            $table->timestamp('starting_at');
            $table->text('description')->nullable();
            $table->uuid('price_list_type_id');
            $table->foreign('price_list_type_id')
                ->references('id')
                ->on('price_list_types');
            $table->uuid('doctype_id');
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->uuid('exchange_rate_id')->nullable();
            $table->foreign('exchange_rate_id')
                ->references('id')
                ->on('exchange_rates');
            $table->uuid('reference_price_list_type_id')->nullable();
            $table->foreign('reference_price_list_type_id')
                ->references('id')
                ->on('price_list_types');
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->uuid('amount_operation_id')->nullable();
            $table->foreign('amount_operation_id')
                ->references('id')
                ->on('amount_operations');
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
        Schema::dropIfExists('price_lists');
    }
}
