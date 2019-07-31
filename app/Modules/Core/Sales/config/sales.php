<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

    'menu' => [
            'name' => 'view.menu.sales',
            'icon' => 'local_offer',
            'route' => 'admin.sales',
            'routes' => [
                'admin.sales.price_lists.index',
                'admin.sales.price_list_types.index',
                'admin.sales.customers.index',
                'admin.sales.categories.index',
                'admin.products.product_output.index',
                'admin.sales.payment_methods.index',
                'admin.sales.sales_channels.index',
                'admin.sales.taxs.index',
                'admin.sales.discounts.index',
                'admin.sales.orders.index',
            ],
            'items' => [
            ],
            'submodules' => [
                [
                    'name' => 'view.menu.general',
                    'icon' => '',
                    'route' => 'admin.sales.general',
                    'routes' => [
                        'admin.sales.price_list_types.index',
                        'admin.sales.customers.index',
                        'admin.sales.categories.index',
                        'admin.sales.payment_methods.index',
                        'admin.sales.sales_channels.index',
                        'admin.sales.taxs.index',
                        'admin.sales.discounts.index',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.categories',
                            'route' => 'admin.sales.categories.index',
                        ],
                        [
                            'name' => 'view.menu.customers',
                            'route' => 'admin.sales.customers.index',
                        ],
                        [
                            'name' => 'view.menu.payment_methods',
                            'route' => 'admin.sales.payment_methods.index',
                        ],
                        [
                            'name' => 'view.menu.sales_channels',
                            'route' => 'admin.sales.sales_channels.index',
                        ],
                        [
                            'name' => 'view.menu.taxs',
                            'route' => 'admin.sales.taxs.index',
                        ],
                        [
                            'name' => 'view.menu.discounts',
                            'route' => 'admin.sales.discounts.index',
                        ],
                        [
                            'name' => 'view.menu.price_list_types',
                            'route' => 'admin.sales.price_list_types.index',
                        ],
                    ],
                ],
                [
                    'name' => 'view.menu.processes',
                    'icon' => '',
                    'route' => 'admin.sales.processes',
                    'routes' => [
                        'admin.sales.price_lists.index',
                        'admin.products.product_output.index',
                        'admin.sales.orders.index',
                    ],
                    'items' => [                        
                        [
                            'name' => 'view.menu.price_list',
                            'route' => 'admin.sales.price_lists.index',
                        ],
                        [
                            'name' => 'view.menu.product_output',
                            'route' => 'admin.products.product_output.index',
                        ],
                        [
                            'name' => 'view.menu.sales_orders',
                            'route' => 'admin.sales.orders.index',
                        ],
                    ],
                ],
        /*      [
                    'name' => 'view.menu.reports',
                    'icon' => '',
                    'route' => 'admin.sales.reports',
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
            Basedoc::SO_DOC => [
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