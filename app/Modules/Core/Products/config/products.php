<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

    'menu' => [
            'name' => 'view.menu.warehouse',
            'icon' => 'domain',
            'route' => 'admin.products',
            'routes' => [
                'admin.products.categories',
                'admin.products.products',
                'admin.products.warehouses',
                'admin.products.inventories',
                'admin.products.brands',
                'admin.products.stock',
                'admin.products.transactions',
                'admin.products.uom',
                'admin.products.movements',
            ],
            'items' => [
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
                    'name' => 'view.menu.movements',
                    'route' => 'admin.products.movements.index',
                ],

            ],
            'submodules' => [
                [
                    'name' => 'view.menu.config',
                    'icon' => '',
                    'route' => 'admin.products.general',
                    'routes' => [
                        'admin.products.categories',
                    //    'admin.products.products',
                    //    'admin.products.warehouses',
                        'admin.products.brands',
                        'admin.products.uom',
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
                        /*
                        [
                            'name' => 'view.menu.products',
                            'route' => 'admin.products.products.index',
                        ],
                        [
                            'name' => 'view.menu.warehouses',
                            'route' => 'admin.products.warehouses.index',
                        ],
                        */
                    ],
                ],
            /*
                [
                    'name' => 'view.menu.processes',
                    'icon' => '',
                    'route' => 'admin.products.processes',
                    'routes' => [
                        'admin.products.inventories',
                        'admin.products.movements',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.inventories',
                            'route' => 'admin.products.inventories.index',
                        ],
                        [
                            'name' => 'view.menu.movements',
                            'route' => 'admin.products.movements.index',
                        ],
                    ],
                ],
            */
                [
                    'name' => 'view.menu.reports',
                    'icon' => '',
                    'route' => 'admin.products.reports',
                    'routes' => [
                        'admin.products.stock',
                        'admin.products.transactions',
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
                [
                    'name' => 'view.menu.imports_exports',
                    'icon' => '',
                    'route' => 'admin.products.imports_exports',
                    'routes' => [
                        'admin.products.products',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.import_products',
                            'route' => 'admin.products.products.showimport',
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
            Basedoc::IM_DOC => [
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