<?php

return [

    'menu' => [
        
            'name' => 'view.menu.purchases',
            'icon' => 'local_grocery_store',
            'route' => 'admin.purchases',
            'routes' => [
                'admin.purchases.suppliers.index',
                'admin.products.product_entry.index',
                'admin.purchases.categories.index',
            ],
            'items' => [
                [
                    'name' => 'view.menu.config',
                    'route' => 'admin.home',
                ],
            ],
            'submodules' => [
                [
                    'name' => 'view.menu.general',
                    'icon' => '',
                    'route' => 'admin.purchases.general',
                    'routes' => [
                        'admin.purchases.suppliers.index',
                        'admin.purchases.categories.index'
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
                        'admin.products.product_entry.index',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.product_entry',
                            'route' => 'admin.products.product_entry.index',
                        ],
                    ],
                ],
                [
                    'name' => 'view.menu.reports',
                    'icon' => '',
                    'route' => 'admin.purchases.reports',
                    'routes' => [
                    ],
                    'items' => [
                    ],
                ],
            ]
        
    ],

    'document' => [
        'actions' => [
            'inv' => [
                'pe' => [
                    'key' => 'pending',
                    'name' => 'view.pending',
                    'after_name' => 'view.pending',
                    'new_actions' => ['pr'],
                    'actions_from' => [],
                    'color' => 'gold',
                ],
                'pr' => [
                    'key' => 'process',
                    'name' => 'view.process',
                    'after_name' => 'view.processed',
                    'new_actions' => [],
                    'actions_from' => ['pe'],
                    'color' => 'limegreen',
                ],
                'ca' => [
                    'key' => 'cancel',
                    'name' => 'view.cancel',
                    'after_name' => 'view.canceled',
                    'new_actions' => [],
                    'actions_from' => [],
                    'color' => 'tomato',
                ],
                're' => [ // reverse document at the same date
                    'key' => 'reverse',
                    'name' => 'view.reverse',
                    'after_name' => 'view.reversed',
                    'new_actions' => [],
                    'actions_from' => [],
                    'color' => 'wheat',
                ]
            ]
        ],
    ],
];