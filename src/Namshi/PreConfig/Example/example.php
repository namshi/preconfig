<?php

require __DIR__ . '/../PreConfig.php';

function example()
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

    return $configs->get('users');
}

print_r(example());

/* The Output:
 [
    'someImportantDude' => [
        'username'      => 'him',
        'password'      => '...',
        'credentials'   => '{{ credentials.admin }}'
    ]
]
*/


function exampleMultiLevel()
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

    return $configs->get('users.someImportantDude');
}

print_r(exampleMultiLevel());

/* The Output:
 [
    'username'      => 'him',
    'password'      => '...',
    'credentials'   => '{{ credentials.admin }}'
]

*/


function exampleWithParams()
{
    $argument = [
        'hi' => 'Hello, :name'
    ];

    $configs = new \Namshi\PreConfig\PreConfig($argument);

    return $configs->get('hi', ['name' => 'Ayham']);
}

print_r(exampleWithParams());

/* The Output:
 Hello, Ayham

*/

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