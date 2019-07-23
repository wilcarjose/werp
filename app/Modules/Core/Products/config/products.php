<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

    'menu' => [
            'name' => 'view.menu.products',
            'icon' => 'domain',
            'route' => 'admin.products',
            'routes' => [
                'admin.products.categories.index',
                'admin.products.products.index',
                'admin.products.warehouses.index',
                'admin.products.inventories.index',
                'admin.products.brands.index',
                'admin.products.price_lists.index',
                'admin.products.config.edit',
                'admin.products.price_list_types.index',
                'admin.products.stock.index',
                'admin.products.transactions.index',
                'admin.products.product_entry.index',
                'admin.products.uom.index',
            ],
            'items' => [
                [
                    'name' => 'view.menu.config',
                    'route' => 'admin.products.config.edit',
                ],
            ],
            'submodules' => [
                [
                    'name' => 'view.menu.general',
                    'icon' => '',
                    'route' => 'admin.products.general',
                    'routes' => [
                        'admin.products.categories.index',
                        'admin.products.products.index',
                        'admin.products.warehouses.index',
                        'admin.products.brands.index',
                        'admin.products.price_list_types.index',
                        'admin.products.uom.index',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.categories',
                            'route' => 'admin.products.categories.index',
                        ],
                        [
                            'name' => 'view.menu.brands',
                            'route' => 'admin.products.brands.index',
                        ],
                        [
                            'name' => 'view.menu.uom',
                            'route' => 'admin.products.uom.index',
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
                            'name' => 'view.menu.price_list_types',
                            'route' => 'admin.products.price_list_types.index',
                        ],
                    ],
                ],
                [
                    'name' => 'view.menu.processes',
                    'icon' => '',
                    'route' => 'admin.products.processes',
                    'routes' => [
                        'admin.products.inventories.index',
                        'admin.products.price_lists.index',
                        'admin.products.product_entry.index',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.inventories',
                            'route' => 'admin.products.inventories.index',
                        ],
                        [
                            'name' => 'view.menu.price_list',
                            'route' => 'admin.products.price_lists.index',
                        ],
                        [
                            'name' => 'view.menu.product_entry',
                            'route' => 'admin.products.product_entry.index',
                        ],
                    ],
                ],
                [
                    'name' => 'view.menu.reports',
                    'icon' => '',
                    'route' => 'admin.products.reports',
                    'routes' => [
                        'admin.products.stock.index',
                        'admin.products.transactions.index',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.stock',
                            'route' => 'admin.products.stock.index',
                        ],
                        [
                            'name' => 'view.menu.transactions',
                            'route' => 'admin.products.transactions.index',
                        ],
                    ],
                ],
            ]
    ],

    'document' => [
        'actions' => [
            Basedoc::IN_DOC => [
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
                    'new_actions' => [],
                    'actions_from' => [Basedoc::PE_STATE],
                    'color' => 'limegreen',
                ],
                Basedoc::CA_STATE => [
                    'key' => 'cancel',
                    'name' => 'view.cancel',
                    'after_name' => 'view.canceled',
                    'new_actions' => [],
                    'actions_from' => [],
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
            Basedoc::PL_DOC => [
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
                    'new_actions' => [Basedoc::RE_STATE],
                    'actions_from' => [Basedoc::PE_STATE],
                    'color' => 'limegreen',
                ],
                Basedoc::CA_STATE => [
                    'key' => 'cancel',
                    'name' => 'view.cancel',
                    'after_name' => 'view.canceled',
                    'new_actions' => [],
                    'actions_from' => [],
                    'color' => 'tomato',
                ],
                Basedoc::RE_STATE => [ // reverse document at the same date
                    'key' => 'reverse',
                    'name' => 'view.reverse',
                    'after_name' => 'view.reversed',
                    'new_actions' => [Basedoc::PR_STATE],
                    'actions_from' => [Basedoc::PR_STATE],
                    'color' => 'wheat',
                ]
            ],
            Basedoc::IE_DOC => [
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
            Basedoc::IO_DOC => [
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
                    'new_actions' => [Basedoc::RE_STATE],
                    'actions_from' => [Basedoc::PE_STATE],
                    'color' => 'limegreen',
                ],
                Basedoc::CA_STATE => [
                    'key' => 'cancel',
                    'name' => 'view.cancel',
                    'after_name' => 'view.canceled',
                    'new_actions' => [],
                    'actions_from' => [],
                    'color' => 'tomato',
                ],
                Basedoc::RE_STATE => [ // reverse document at the same date
                    'key' => 'reverse',
                    'name' => 'view.reverse',
                    'after_name' => 'view.reversed',
                    'new_actions' => [Basedoc::PR_STATE],
                    'actions_from' => [Basedoc::PR_STATE],
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