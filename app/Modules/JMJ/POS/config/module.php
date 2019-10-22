<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

    'menu' => [

            'name' => 'view.menu.pos',
            'icon' => 'add_shopping_cart',
            'route' => 'admin.pos',
            'routes' => [
                'admin.pos.pos',
            ],
            'items' => [
                [
                    'name' => 'view.menu.point_of_sale',
                    'route' => 'admin.pos.pos.view',
                ],
            ],

            'submodules' => [

            ]
    ],
];
