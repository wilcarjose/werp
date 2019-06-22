<?php

use Carbon\Carbon;
use Werp\Permissions;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
	protected $permissions = [
		['developerOnly', 'developerOnly'],
		['security', 'Seguridad'],
		['admin.list', 'Admin List'],
		['admin.create', 'Admin Create'],
		['admin.edit', 'Admin Edit'],
		['admin.update', 'Admin Update'],
		['admin.remove', 'Admin Delete'],
		['admin.products.products.index', 'Listar productos'],
		['admin.products', 'Módulo de productos'],
		['admin.products.categories.index', 'Listar categorías de productos'],
		['admin.products.warehouses.index', 'Listar almacenes'],
		['admin.products.inventories.index', 'Listar inventarios'],
		['admin.products.config.edit', 'Configurar módulo de productos'],
		['roles.list', 'Listar Roles'],
		['permissions.assign', 'Asignar Permisos'],

	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach ($this->permissions as $permission) {
	        DB::table('permissions')->insert([
	            [
					'name'       => $permission[0],
					'label'      => $permission[1],
	            ],
	        ]);
	    }
    }
}
