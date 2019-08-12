<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

	'show_elements' => false,

	'currencies' => [
		[
			'abbr' => 'USD',
			'name' => 'Dolar',
			'numeric_code' => 840,
			'symbol' => '$'
		],
		[
			'abbr' => 'VEF',
			'name' => 'Bolívar',
			'numeric_code' => 937,
			'symbol' => 'Bs'
		],
		[
			'abbr' => 'COP',
			'name' => 'Peso Colombiano',
			'numeric_code' => 170,
			'symbol' => '$'
		]
	],

	'operations' => [
		[
			'id'   => 'add_amount',
		    'name' => 'Sumar',
		],
		[
			'id'   => 'sub_amount',
		    'name' => 'Restar',
		],
		[
		    'id'   => 'multiply',
		    'name' => 'Multiplicar por',
		],
		[
		    'id'   => 'divide',
		    'name' => 'Dividir entre',
		],
		[
			'id'   => 'add_percent',
		    'name' => 'Sumar porcentaje',
		],
		[
			'id'   => 'sub_percent',
		    'name' => 'Restar porcentaje',
		],
	],

	'rounds' => [
		[
		    'id'   => '2',
		    'name' => '2 decimales',
		],
		[
		    'id'   => '1',
		    'name' => '1 decimal',
		],
		[
		    'id'   => '0',
		    'name' => 'Sin decimales',
		],
		[
		    'id'   => '-1',
		    'name' => 'Decenas',
		],
		[
		    'id'   => '-2',
		    'name' => 'Centenas',
		],
		[
		    'id'   => '-3',
		    'name' => 'Miles',
		],
	],

	'doctypes' => [
		Basedoc::IN_DOC => 'view.doctypes.inventory',
		Basedoc::PL_DOC => 'view.doctypes.price_list',
		Basedoc::PO_DOC => 'view.doctypes.purchase_order',
		Basedoc::SO_DOC => 'view.doctypes.sale_order',
		Basedoc::IE_DOC => 'view.doctypes.inventory_entry',
		Basedoc::IO_DOC => 'view.doctypes.inventory_output',
		Basedoc::IM_DOC => 'view.doctypes.inventory_movement',
	],

	'sales_orders' => [
		'generate_output' => true,
	],

	'purchases_orders' => [
		'generate_entry' => true,
	],	

];