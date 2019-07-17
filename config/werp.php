<?php

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
		    'id'   => 'multiply',
		    'name' => 'Multiplicar',
		],
		[
			'id'   => 'add_percent',
		    'name' => 'Sumar porcentaje',
		],
		[
			'id'   => 'sub_percent',
		    'name' => 'Restar porcentaje',
		],
		[
			'id'   => 'add_amount',
		    'name' => 'Sumar monto',
		],
		[
			'id'   => 'sub_amount',
		    'name' => 'Restar monto',
		]
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
		'INV' => 'view.doctypes.inventory',
		'LP' => 'view.doctypes.price_list'
	]

];