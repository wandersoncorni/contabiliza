<?php
return [
    [
        'label' => 'Painel',
        'route' => '/painel',
        'icon' => 'heroicon-retangle-group',
    ],
    [
        'label' => 'Licenciados',
        'route' => '/licensed',
        'icon' => 'heroicon-modern-house',
        'roles' => ['admin'],
    ],
    [
        'label' => 'Usuários',
        'route' => '/users',
        'icon' => 'heroicon-users',
        'roles' => ['admin'],
    ],
    [
        'label' => 'Consultores',
        'route' => '/consultants',
        'icon' => 'heroicon-users',
        'roles' => ['manager'],
    ],
    [
        'label' => 'Clientes',
        'route' => '/clients',
        'icon' => 'heroicon-users',
        'roles' => ['manager','consultant'],
    ],
    [
        'label' => 'Agentes',
        'route' => '/agents',
        'icon' => 'heroicon-users',
        'roles' => ['manager','consultant','client'],
    ],
    [
        'label' => 'Empresas',
        'route' => '/companies',
        'icon' => 'heroicon-modern-house',
        'roles' => ['manager','consultant','client'],
    ],
    [
        'label' => 'Sócios',
        'route' => '/partners',
        'icon' => 'heroicon-users',
        'roles' => ['manager','consultant','client'],
    ]
];