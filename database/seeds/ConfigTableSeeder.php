<?php

use Carbon\Carbon;
use Werp\Permissions;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Company;

class ConfigTableSeeder extends Seeder
{
	protected $configs = [

		// Dolar value
		['Valor del Dolar ($)', Config::CURRENT_DOLAR_CONVERSION, 0, 'mai', 'view.maintenance.dolar_value', 'amount'],

		// Default warehouse
		['view.products.default_warehouse', Config::INV_DEFAULT_WAREHOUSE, 0, 'inv', 'view.products.default_warehouse', 'entity'],

		// Default doctypes
		['view.products.default_inventory_doc', Config::INV_DEFAULT_IN_DOC, 1, 'inv', 'view.products.default_inventory_doc', 'doctype'],
		['view.products.default_price_list_doc', Config::PRI_DEFAULT_PL_DOC, 2, 'pri', 'view.products.default_price_list_doc', 'doctype'],
		['view.products.default_ie_doc', Config::INV_DEFAULT_IE_DOC, 0, 'inv', 'view.products.default_ie_doc', 'doctype'],
		['view.products.default_po_doc', Config::INV_DEFAULT_PO_DOC, 0, 'inv', 'view.products.default_po_doc', 'doctype'],
		['view.products.default_io_doc', Config::INV_DEFAULT_IO_DOC, 0, 'inv', 'view.products.default_io_doc', 'doctype'],
		['view.products.default_so_doc', Config::INV_DEFAULT_SO_DOC, 0, 'inv', 'view.products.default_so_doc', 'doctype'],
		['view.products.default_im_doc', Config::INV_DEFAULT_IM_DOC, 0, 'inv', 'view.products.default_im_doc', 'doctype'],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$company = Company::first();
    	
    	foreach ($this->configs as $config) {
	        Config::create(
	            [
	            	'name'			=> $config[0],
					'key'           => $config[1],
					'value'         => $config[2],
					'module'        => $config[3],
					'translate_key' => $config[4],
					'type' 			=> $config[5],
					'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                	'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                	'company_id' 	=> $company->id,
	            ]
	        );
	    }
    }
}
