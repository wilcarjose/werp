<?php

return [

    'user' => [
        'title'  => 'Users',
        'action' => 'Add User',
        'action_short' => 'Add',
        'route'  => 'admin.user',
        'edit'   => false,
        'data'   => [
            'id'    => 0,
            'name'  => '',
            'email' => '',
            'pic'   => '',
        ],
        'inputs' => [
            'name'  => ['type' => 'input', 'attr' => ['name' => 'name', 'icon' => 'person', 'text' => 'Name', 'value' => '']],
            'email' => ['type' => 'email', 'attr' => ['name' => 'email', 'icon' => 'email', 'text' => 'Email', 'value' => '']],
            'pic'   => ['type' => 'image', 'attr' => ['name' => 'pic', 'default' => '/images/square/admin.png', 'value' => '']],
        ],
        'actions' => [
            'save'   => ['type' => 'button', 'attr' => ['name' => 'update_profile', 'type' => 'submit', 'text' => 'User', 'icon' => 'add']],
            'cancel' => ['type' => 'link', 'attr' => ['name' => '', 'type' => 'button', 'text' => 'Cancel', 'icon' => '', 'route' => '/admin/user']]
        ],
        'breadcrumb' => [
            'home'   => ['route' => '/admin/home', 'text' => 'Home'],
            'object' => ['route' => 'admin.user.index', 'text' => 'Users'],
            'action' => ['route' => 'admin.user.', 'text' => 'Add'],
        ]
    ]
];