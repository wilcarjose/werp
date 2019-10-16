<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

    'menu' => [

            'name' => 'view.menu.mercado_libre',
            'icon' => 'local_grocery_store',
            'route' => 'admin.ml',
            'routes' => [
                'admin.ml.update-prices',
                'admin.ml.config',
                'admin.ml.login',
            ],
            'items' => [
                [
                    'name' => 'view.menu.config',
                    'route' => 'admin.ml.config.edit',
                ],
                [
                    'name' => 'view.menu.login',
                    'route' => 'admin.ml.login.view',
                ],
                [
                    'name' => 'view.menu.update_prices',
                    'route' => 'admin.ml.update-prices.edit',
                ],
            ],

            'submodules' => [

            ]
    ],

    'countries' => [
        [
            'id' =>  'https://auth.mercadolibre.com.ar',
            'name' => 'ML Argentina'
        ],
        [
            'id' =>  'https://auth.mercadolivre.com.br',
            'name' => 'ML Brasil'
        ],
        [
            'id' =>  'https://auth.mercadolibre.cl',
            'name' => 'ML Chile'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.co',
            'name' => 'ML Colombia'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.cr',
            'name' => 'ML Costa Rica'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.do',
            'name' => 'ML Dominicana'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.ec',
            'name' => 'ML Ecuador'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.mx',
            'name' => 'ML Mexico'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.pa',
            'name' => 'ML Panama'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.pe',
            'name' => 'ML Peru'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.pt',
            'name' => 'ML Portugal'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.uy',
            'name' => 'ML Uruguay'
        ],
        [
            'id' =>  'https://auth.mercadolibre.com.ve',
            'name' => 'ML Venezuela'
        ],
    ]
];
