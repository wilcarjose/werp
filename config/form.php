<?php

return [

    'user' => [
        'inputs' => [
            ['type' => 'input', 'attr' => ['name' => 'name', 'icon' => 'person', 'text' => 'Name']],
            ['type' => 'email', 'attr' => ['name' => 'email', 'icon' => 'email', 'text' => 'Email']],
            ['type' => 'image', 'attr' => ['name' => 'pic', 'default' => url('/images/square/admin.png')]],
        ]
    ]

];