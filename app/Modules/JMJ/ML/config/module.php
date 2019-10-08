<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

    'menu' => [
        
            'name' => 'view.menu.mercado_libre',
            'icon' => 'local_grocery_store',
            'route' => 'admin.ml',
            'routes' => [
                'admin.ml.update-prices',
            ],
            'items' => [
                [
                    'name' => 'view.menu.update_prices',
                    'route' => 'admin.ml.update-prices.edit',
                ],
            ],
        
            'submodules' => [
                
            ]
    ],
];