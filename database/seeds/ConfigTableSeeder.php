<?php

use Carbon\Carbon;
use Werp\Permissions;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Maintenance\Models\Config;

class ConfigTableSeeder extends Seeder
{
	protected $configs = [

		// Default warehouse
		[Config::INV_DEFAULT_WAREHOUSE, 0, 'inv', 'view.products.default_warehouse'],

		// Default doctypes
		[Config::INV_DEFAULT_IN_DOC, 1, 'inv', 'view.products.default_inventory_doc'],
		[Config::PRI_DEFAULT_PL_DOC, 2, 'pri', 'view.products.default_price_list_doc'],
		[Config::INV_DEFAULT_IE_DOC, 0, 'inv', 'view.products.default_ie_doc'],
		[Config::INV_DEFAULT_PO_DOC, 0, 'inv', 'view.products.default_po_doc'],
		[Config::INV_DEFAULT_IO_DOC, 0, 'inv', 'view.products.default_io_doc'],
		[Config::INV_DEFAULT_SO_DOC, 0, 'inv', 'view.products.default_so_doc'],
		[Config::INV_DEFAULT_IM_DOC, 0, 'inv', 'view.products.default_im_doc'],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach ($this->configs as $config) {
	        DB::table('config')->insert([
	            [
					'key'           => $config[0],
					'value'         => $config[1],
					'module'        => $config[2],
					'translate_key' => $config[3],
					'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                	'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
	            ],
	        ]);
	    }
    }
}
