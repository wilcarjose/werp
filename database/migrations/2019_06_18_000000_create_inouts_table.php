<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Products\Models\Inout;
use Illuminate\Database\Migrations\Migration;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class CreateInoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inouts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->timestamp('date');
            $table->string('order_code')->nullable();
            $table->string('alternate_code')->nullable();
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            $table->double('total_price', 10, 4)->default(0.0000);
            $table->double('total_tax', 10, 4)->default(0.0000);
            $table->double('total_discount', 10, 4)->default(0.0000);
            $table->double('total', 10, 4)->default(0.0000);
            $table->string('currency')->default('USD');
            $table->enum('type', [Inout::OUT_TYPE, Inout::IN_TYPE])->default(Inout::OUT_TYPE);
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->uuid('partner_id');
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
            $table->uuid('doctype_id');
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->uuid('warehouse_id')->nullable();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
            $table->uuid('tax_id')->nullable();
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxs');
            $table->uuid('discount_id')->nullable();
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts');
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
        Schema::dropIfExists('inouts');
    }
}
