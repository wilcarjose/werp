<?php

use Werp\Role;
use Werp\Permission;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$permission = Permission::where('name', 'developerOnly')->first();
		$role       = Role::where('name', 'developer')->first();
		$role->givePermissionTo($permission);
    }
}
