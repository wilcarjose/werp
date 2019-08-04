<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Base\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('document');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('web')->nullable();
            $table->string('photo')->nullable();
            $table->string('type')->nullable();
            $table->enum('is_supplier',['y','n'])->default('n');
            $table->enum('is_customer',['y','n'])->default('n');
            $table->text('description')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('economic_activity')->nullable(); // rubro
            $table->enum('gender',['m','f','o'])->nullable();
            $table->uuid('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->uuid('address_id')->nullable();
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
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
        Schema::dropIfExists('partners');
    }
}
