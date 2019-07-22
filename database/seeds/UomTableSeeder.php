<?php

use Carbon\Carbon;
use Werp\Permissions;
use Illuminate\Database\Seeder;

class UomTableSeeder extends Seeder
{
	protected $uom = [
		[
			'name' => 'Unidad',
			'abbr' => 'Unidad',
		],
		[
			'name' => 'Litro',
			'abbr' => 'Lt',
		],
		[
			'name' => 'Kilo',
			'abbr' => 'Kg',
		],
		[
			'name' => 'Galón',
			'abbr' => 'Gl',
		]
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach ($this->uom as $uom) {
	        DB::table('uom')->insert([
	            [
					'name' => $uom['name'],
					'abbr' => $uom['abbr'],
	            ],
	        ]);
	    }
    }
}
