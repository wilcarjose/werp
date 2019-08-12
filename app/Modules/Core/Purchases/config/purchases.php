<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

    'menu' => [
        
            'name' => 'view.menu.purchases',
            'icon' => 'local_grocery_store',
            'route' => 'admin.purchases',
            'routes' => [
                'admin.purchases.suppliers.index',
                'admin.products.product_entry.index',
                'admin.purchases.categories.index',
                'admin.purchases.orders.index',
            ],
         'items' => [
        /*      [
                    'name' => 'view.menu.config',
                    'route' => 'admin.home',
                ],
        */
            ],
        
            'submodules' => [
                [
                    'name' => 'view.menu.general',
                    'icon' => '',
                    'route' => 'admin.purchases.general',
                    'routes' => [
                        'admin.purchases.suppliers.index',
                        'admin.purchases.categories.index',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.categories',
                            'route' => 'admin.purchases.categories.index',
                        ],
                        [
                            'name' => 'view.menu.suppliers',
                            'route' => 'admin.purchases.suppliers.index',
                        ],
                    ],
                ],
                [
                    'name' => 'view.menu.processes',
                    'icon' => '',
                    'route' => 'admin.purchases.processes',
                    'routes' => [
                        'admin.purchases.orders.index',
                        'admin.products.product_entry.index',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.purchases_orders',
                            'route' => 'admin.purchases.orders.index',
                        ],
                        [
                            'name' => 'view.menu.product_entry',
                            'route' => 'admin.products.product_entry.index',
                        ],
                    ],
                ],
        /*        [
                    'name' => 'view.menu.reports',
                    'icon' => '',
                    'route' => 'admin.purchases.reports',
                    'routes' => [
                    ],
                    'items' => [
                    ],
                ],
        */
            ]
        
    ],

    'document' => [
        'actions' => [
            Basedoc::PO_DOC => [
                Basedoc::PE_STATE => [
                    'key' => 'pending',
                    'name' => 'view.pending',
                    'after_name' => 'view.pending',
                    'new_actions' => [Basedoc::PR_STATE],
                    'actions_from' => [],
                    'color' => 'gold',
                ],
                Basedoc::PR_STATE => [
                    'key' => 'process',
                    'name' => 'view.process',
                    'after_name' => 'view.processed',
                    'new_actions' => [Basedoc::CA_STATE],
                    'actions_from' => [Basedoc::PE_STATE],
                    'color' => 'limegreen',
                ],
                Basedoc::CA_STATE => [
                    'key' => 'cancel',
                    'name' => 'view.cancel',
                    'after_name' => 'view.canceled',
                    'new_actions' => [],
                    'actions_from' => [Basedoc::PR_STATE],
                    'color' => 'tomato',
                ],
                Basedoc::RE_STATE => [ // reverse document at the same date
                    'key' => 'reverse',
                    'name' => 'view.reverse',
                    'after_name' => 'view.reversed',
                    'new_actions' => [],
                    'actions_from' => [],
                    'color' => 'wheat',
                ]
            ],
        ],
    ],
];