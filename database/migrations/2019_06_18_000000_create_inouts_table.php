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
            $table->increments('id');
            $table->string('code')->unique();
            $table->dateTime('date');
            $table->string('order_code')->nullable();
            $table->string('alternate_code')->nullable();
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            $table->double('amount', 10, 4)->default(0.0000);
            $table->double('tax_amount', 10, 4)->default(0.0000);
            $table->double('discount_amount', 10, 4)->default(0.0000);
            $table->double('total_amount', 10, 4)->default(0.0000);
            $table->string('currency')->default('USD');
            $table->enum('type', [Inout::OUT_TYPE, Inout::IN_TYPE])->default(Inout::OUT_TYPE);
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->integer('partner_id')->unsigned();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
            $table->integer('doctype_id')->unsigned();
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->nullable();
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
