<?php

use Carbon\Carbon;
use Werp\Permissions;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
	protected $permissions = [
		['developerOnly', 'developerOnly', 'y', null],
		['admin.products', 'Módulo de productos', 'y', null],
		['security', 'Módulo de Seguridad', 'y', null],
		['admin.purchases', 'Módulo de Compras', 'y', null],

		['admin.products.products.index', 'Listar productos', 'n', 2],
		['admin.products.categories.index', 'Listar categorías de productos', 'n', 2],
		['admin.products.warehouses.index', 'Listar almacenes', 'n', 2],
		['admin.products.inventories.index', 'Listar inventarios', 'n', 2],
		['admin.products.brands.index', 'Listar marcas', 'n', 2],
		['admin.products.config.edit', 'Configurar módulo de productos', 'n', 2],
		
		['admin.list', 'Listar Usuarios', 'n', 3],
		['admin.create', 'Crear Usuarios', 'n', 3],
		['admin.edit', 'Editar Usuarios', 'n', 3],
		['admin.update', 'Actualizar Usuarios', 'n', 3],
		['admin.remove', 'Eliminar Usuarios', 'n', 3],
		['roles.list', 'Listar Roles', 'n', 3],
		['permissions.assign', 'Asignar Permisos', 'n', 3],

		['admin.purchases.suppliers.index', 'Listar Proveedores', 'n', 4],
		['admin.purchases.categories.index', 'Listar categorías de proveedores', 'n', 4],

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
					'name'          => $permission[0],
					'label'         => $permission[1],
					'is_group'      => $permission[2],
					'permission_id' => $permission[3],
	            ],
	        ]);
	    }
    }
}
