<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Products\Models\Uom;
use Werp\Modules\Core\Maintenance\Models\Company;

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
    	$company_id = Company::first()->id;
    	foreach ($this->uom as $uom) {
    		$uom['company_id'] = $company_id;
	        Uom::create($uom);
	    }
    }
}
