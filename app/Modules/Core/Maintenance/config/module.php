<?php

use Werp\Modules\Core\Maintenance\Models\Basedoc;

return [

    'menu' => [
            'name' => 'view.menu.maintenance',
            'icon' => 'settings',
            'route' => 'admin.maintenance',
            'routes' => [
                'admin.maintenance.company',
                'admin.maintenance.config',
                'admin.maintenance.amount_operations',
                'admin.maintenance.currencies',
                'admin.maintenance.exchange_rates',
                'admin.maintenance.db_backups',
                'admin.maintenance.db_test',
                'admin.maintenance.price_lists',
                'admin.maintenance.price_list_types',
            ],
            'items' => [
                [
                    'name' => 'view.menu.price_list',
                    'route' => 'admin.maintenance.price_lists.index',
                ],
            ],
            'submodules' => [
                [
                    'name' => 'view.menu.config',
                    'icon' => '',
                    'route' => 'admin.maintenance.general',
                    'routes' => [
                        'admin.maintenance.company',
                        'admin.maintenance.config',
                        'admin.maintenance.amount_operations',
                        'admin.maintenance.currencies',
                        'admin.maintenance.exchange_rates',
                        'admin.maintenance.price_list_types',
                    ],
                    'items' => [
                        [
                            'name' => 'view.menu.company',
                            'route' => 'admin.maintenance.company.edit',
                        ],
                        [
                            'name' => 'view.menu.config',
                            'route' => 'admin.maintenance.config.edit',
                        ],
                        [
                            'name' => 'view.menu.amount_operations',
                            'route' => 'admin.maintenance.amount_operations.index',
                        ],
                        [
                            'name' => 'view.menu.currencies',
                            'route' => 'admin.maintenance.currencies.index',
                        ],
                        [
                            'name' => 'view.menu.exchange_rates',
                            'route' => 'admin.maintenance.exchange_rates.index',
                        ],
                        [
                            'name' => 'view.menu.price_list_types',
                            'route' => 'admin.maintenance.price_list_types.index',
                        ],
                    ],
                ],
                [
                    'name' => 'view.menu.database',
                    'icon' => '',
                    'route' => 'admin.maintenance.processes',
                    'routes' => [
                        'admin.maintenance.db_test',
                        'admin.maintenance.db_backups',
                    ],
                    'items' => [                        
                        [
                            'name' => 'view.menu.db_test',
                            'route' => 'admin.maintenance.db_test.edit',
                        ],
                        [
                            'name' => 'view.menu.db_backups',
                            'route' => 'admin.maintenance.db_backups.index',
                        ],
                    ],
                ],
        /*
                [
                    'name' => 'view.menu.reports',
                    'icon' => '',
                    'route' => 'admin.maintenance.reports',
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