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
		'generate_price_list' => true
	],

	'transaction_color' => [
		Basedoc::IN_DOC => 'rgb(224, 102, 102)',
		Basedoc::PL_DOC => 'rgb(246, 178, 107)',
		Basedoc::PO_DOC => 'rgb(147, 196, 125)',
		Basedoc::SO_DOC => 'rgb(118, 165, 175)',
		Basedoc::IE_DOC => 'rgb(142, 124, 195)',
		Basedoc::IO_DOC => 'rgb(194, 123, 160)',
		Basedoc::IM_DOC => 'rgb(111, 168, 220)',

	],

	'transaction_route' => [
		Basedoc::IN_DOC => 'admin.products.inventories',
		Basedoc::PL_DOC => 'admin.sales.price_list',
		Basedoc::PO_DOC => 'admin.purchases.order',
		Basedoc::SO_DOC => 'admin.sales.order',
		Basedoc::IE_DOC => 'admin.products.product_entry',
		Basedoc::IO_DOC => 'admin.products.product_output',
		Basedoc::IM_DOC => 'admin.products.movements',
	],

	'transaction_initials' => [
		Basedoc::IN_DOC => 'IN',
		Basedoc::PL_DOC => 'LP',
		Basedoc::PO_DOC => 'OC',
		Basedoc::SO_DOC => 'OV',
		Basedoc::IE_DOC => 'EP',
		Basedoc::IO_DOC => 'SP',
		Basedoc::IM_DOC => 'MI',
	],

];