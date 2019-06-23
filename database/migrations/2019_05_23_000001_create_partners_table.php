<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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
            $table->increments('id');
            $table->string('document');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('web')->nullable();
            $table->string('photo')->nullable();
            $table->enum('is_supplier',['y','n'])->default('n');
            $table->enum('is_scustomer',['y','n'])->default('n');
            $table->text('description')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('economic_activity')->nullable(); // rubro
            $table->enum('gender',['m','f','o'])->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
            $table->enum('status',['active','inactive'])->default('active');
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
        Schema::dropIfExists('partners');
    }
}
