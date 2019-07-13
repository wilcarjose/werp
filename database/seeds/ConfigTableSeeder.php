<?php

use Carbon\Carbon;
use Werp\Permissions;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
	protected $configs = [
		['inv_default_inventory_doctype', 1, 'inv', 'view.products.default_inventory_doc'],
		['inv_default_warehouse', 0, 'inv', 'view.products.default_warehouse'],
		['pri_default_price_list_doctype', 2, 'pri', 'view.products.default_price_list_doc'],
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
