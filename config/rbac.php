<?php
/**
 * Hierarquia
 * root
 * |- admin
 *    |- manager
 *       |- consultant
 * |- user
 */
return [
    'roles' => [
        'root' => [
            'permissions' => []
        ],
        'admin' => [
            'permissions' => ['delete.user'],
            'parents' => ['root']
        ],
        'manager' => [
            'permissions' => ['create.user', 'update.user'],
            'parents' => ['admin']
        ],
        'consultant' => [
            'permissions' => ['create.register', 'update.register'],
            'parents' => ['manager']
        ],
        'client' => [
            'permissions' => ['read.reports'],
            'parents' => ['consultant']
        ],
        'associated' => [
            'permissions' => ['read.reports'],
            'parents' => ['client']
        ]
    ]
];