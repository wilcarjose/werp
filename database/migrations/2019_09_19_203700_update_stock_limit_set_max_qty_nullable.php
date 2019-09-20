<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\FloatType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStockLimitSetMaxQtyNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Type::hasType('double')) {
                Type::addType('double', FloatType::class);
        }

        Schema::table('stock_limit', function (Blueprint $table) {
            $table->double('max_qty')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_limit', function (Blueprint $table) {
            $table->double('max_qty',)->change();
        });
    }
}