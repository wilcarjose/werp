<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Base\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->string('alternate_code')->nullable();
            $table->string('part_number')->nullable();
            $table->string('model')->nullable();
            $table->text('description')->nullable();
            $table->string('barcode')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('link')->nullable();
            $table->uuid('uom_id')->nullable();
            $table->foreign('uom_id')
                ->references('id')
                ->on('uom');
            $table->string('single_unit_code')->nullable();
            $table->string('pack_code')->nullable();
            $table->string('image')->nullable();
            $table->string('size')->nullable();
            $table->string('weight')->nullable();
            $table->string('type'); // storable, asset, service
            $table->enum('has_lots', ['y','n'])->default('n');
            $table->enum('has_instances', ['y','n'])->default('n');
            $table->enum('has_attributes', ['y','n'])->default('n');
            $table->double('unit_cost', 20, 4)->default(0.0000);
            $table->text('warranty_terms')->nullable();
            $table->text('notes')->nullable();
            $table->uuid('generic_product_id')->nullable();
            $table->foreign('generic_product_id')
                ->references('id')
                ->on('generic_products');
            $table->uuid('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->uuid('product_group_id')->nullable();
            $table->foreign('product_group_id')
                ->references('id')
                ->on('product_groups');
            $table->uuid('brand_id')->nullable();
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands');
            $table->uuid('partner_id')->nullable();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
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
        Schema::dropIfExists('products');
    }
}
