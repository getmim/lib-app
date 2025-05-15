<?php

return [
    '__name' => 'lib-app',
    '__version' => '1.1.0',
    '__git' => 'git@github.com:getmim/lib-app.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-app' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-model' => null
            ],
            [
                'lib-user' => null
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibApp\\Model' => [
                'type' => 'file',
                'base' => 'modules/lib-app/model'
            ],
            'LibApp\\Service' => [
                'type' => 'file',
                'base' => 'modules/lib-app/service'
            ],
            'LibApp\\Iface' => [
                'type' => 'file',
                'base' => 'modules/lib-app/interface'
            ]
        ],
        'files' => []
    ],
    'service' => [
        'app' => 'LibApp\\Service\\App'
    ],
    'libApp' => [
        'authorizer' => []
    ],
    'libFormatter' => [
        'formats' => [
            'app' => [
                'id' => [
                    'type' => 'number'
                ],
                'user' => [
                    'type' => 'user'
                ],
                'name' => [
                    'type' => 'text'
                ],
                'slug' => [
                    'type' => 'text'
                ],
                'updated' => [
                    'type' => 'date'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ]
        ]
    ]
];
