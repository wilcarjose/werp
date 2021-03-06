<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles',function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('label')->nullable();
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('permissions',function(Blueprint $table){
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->enum('is_group',['y','n'])->default('n');
            $table->uuid('permission_id')->nullable();
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('permission_role',function(Blueprint $table){
            $table->uuid('permission_id');
            $table->uuid('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->primary(['permission_id','role_id']);
            $table->softDeletes();
        });

        Schema::create('admin_role',function(Blueprint $table){
            $table->uuid('role_id');
            $table->uuid('admin_id');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->onDelete('cascade');
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->primary(['role_id','admin_id']);
            $table->softDeletes();
        });

        Schema::create('role_user',function(Blueprint $table){
            $table->uuid('role_id');
            $table->uuid('user_id');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->primary(['role_id','user_id']);
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('admin_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_role');
    }
}
