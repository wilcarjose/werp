<?php

use Carbon\Carbon;
use Werp\Permission;
use Illuminate\Database\Seeder;
use Werp\Modules\Base\Maintenance\Models\Company;

class PermissionTableSeeder extends Seeder
{
	protected function getPermissions()
	{
		return [
			[
				'name' => 'developerOnly',
				'label' => 'developerOnly',
				'is_group' => 'y',
				'permission_id' => null,
				'permissions' => [],
			],
			[
				'name' => 'admin.products',
				'label' => 'Módulo de productos',
				'is_group' => 'y',
				'permission_id' => null,
				'permissions' => [
					[
						'name' => 'admin.products.products.index',
						'label' => 'Listar productos', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.products.categories.index',
						'label' => 'Listar categorías de productos', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.products.warehouses.index',
						'label' => 'Listar almacenes', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.products.inventories.index',
						'label' => 'Listar inventarios', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.products.brands.index',
						'label' => 'Listar marcas', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.products.config.edit',
						'label' => 'Configurar módulo de productos', 
						'is_group' => 'n',
					],
				],
			],
			[
				'name' => 'security',
				'label' => 'Módulo de Seguridad',
				'is_group' => 'y',
				'permission_id' => null,
				'permissions' => [
					[
						'name' => 'admin.list',
						'label' => 'Listar Usuarios', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.create',
						'label' => 'Crear Usuarios', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.edit',
						'label' => 'Editar Usuarios', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.update',
						'label' => 'Actualizar Usuarios', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.remove',
						'label' => 'Eliminar Usuarios', 
						'is_group' => 'n',
					],
					[
						'name' => 'roles.list',
						'label' => 'Listar Roles', 
						'is_group' => 'n',
					],
					[
						'name' => 'permissions.assign',
						'label' => 'Asignar Permisos', 
						'is_group' => 'n',
					],
				],
			],
			[
				'name' => 'admin.purchases',
				'label' => 'Módulo de Compras',
				'is_group' => 'y',
				'permission_id' => null,
				'permissions' => [
					[
						'name' => 'admin.purchases.suppliers.index',
						'label' => 'Listar Proveedores', 
						'is_group' => 'n',
					],
					[
						'name' => 'admin.purchases.categories.index',
						'label' => 'Listar categorías de proveedores',
						'is_group' => 'n',
					],
				],
			],
		];
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$company = Company::first();

    	foreach ($this->getPermissions() as $permission) {

    		$children = $permission['permissions'];
    		unset($permission['permissions']);
    		$permission['company_id'] = $company->id;
	        $perm = Permission::create($permission);

	        foreach ($children as $son) {
	        	$son['permission_id'] = $perm->id;
	        	$son['company_id'] = $company->id;
	        	Permission::create($son);
	        }
	    }
    }
}
