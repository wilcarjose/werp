<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Products\Models\Uom;

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
	        Uom::create($uom);
	    }
    }
}
