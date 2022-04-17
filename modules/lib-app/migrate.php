<?php
/**
 * App migrate
 */

return [
    'LibApp\\Model\\App' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'primary_key' => true,
                    'auto_increment' => true 
                ],
                'index' => 1000
            ],
            'user' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => false,
                    'unsigned' => true
                ],
                'index' => 2000
            ],
            'name' => [
                'type' => 'VARCHAR',
                'length' => 100,
                'attrs' => [
                    'null' => false
                ],
                'index' => 3000
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'length' => 100,
                'attrs' => [
                    'null' => false,
                    'unique' => true 
                ],
                'index' => 4000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 10000
            ]
        ],
        'indexes' => [
            'by_user' => [
                'fields' => [
                    'user' => []
                ]
            ]
        ]
    ]
];
