<?php

require __DIR__ . '/../PreConfig.php';

function exampleWithReference()
{
    $argument = [
        'credentials' => [
            'admin' => [
                'read'  => true,
                'write' => true
            ],
            'reader' => [
                'read' => true,
                'write' => false
            ]
        ],
        'users' => [
            'someImportantDude' => [
                'username'      => 'him',
                'password'      => '...',
                'credentials'   => '{{ credentials.admin }}'
            ]
        ]
    ];

    $configs = new \Namshi\PreConfig\PreConfig($argument);

    return $configs->get('users.someImportantDude.credentials');
}

print_r(exampleWithReference());
/* The Output:
[
    'read'  => true,
    'write' => true
]
*/