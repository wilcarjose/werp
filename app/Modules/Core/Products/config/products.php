<?php

return [

    'menu' => [
        [
            'module' => 'view.menu.products',
            'icon' => 'security',
            'route' => ['admin.products'],
            'items' => [
                [
                    'name' => 'view.menu.categories',
                    'route' => 'admin.products.categories.index',
                ],
                [
                    'name' => 'view.menu.products',
                    'route' => 'admin.products.products.index',
                ],
                [
                    'name' => 'view.menu.warehouses',
                    'route' => 'admin.products.warehouses.index',
                ],
                [
                    'name' => 'view.menu.inventories',
                    'route' => 'admin.products.inventories.index',
                ],
                [
                    'name' => 'view.menu.config',
                    'route' => 'admin.products.config.edit',
                ],
            ],
        ],
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

    'pages' => [
        'category' => [
            'title'  => 'Categories',
            'action' => 'Add Category',
            'action_short' => 'Add',
            'route'  => 'admin.categories',
            'edit'   => false,
            'data'   => [
                'id'    => 0,
                'name'  => '',
            ],
            'inputs' => [
                'name'  => ['type' => 'input', 'attr' => ['name' => 'name', 'icon' => 'person', 'text' => 'Name', 'value' => '']],
            ],
            'actions' => [
                'save'   => ['type' => 'button', 'attr' => ['name' => 'update_category', 'event' => 'submit', 'text' => 'Category', 'icon' => 'add']],
                'cancel' => ['type' => 'link', 'attr' => ['name' => '', 'event' => 'button', 'text' => 'Cancel', 'icon' => '', 'route' => '/admin/categories']]
            ],
            'breadcrumb' => [
                'home'   => ['route' => '/admin/home', 'text' => 'Home'],
                'object' => ['route' => 'admin.categories.index', 'text' => 'Categories'],
                'action' => ['route' => 'admin.categories.', 'text' => 'Add'],
            ]
        ]
    ]
];