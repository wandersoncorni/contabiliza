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
        'label' => 'Carteiras',
        'route' => '/portfolios',
        'icon' => 'heroicon-folder-opened',
        'roles' => ['manager'],
    ],
    [
        'label' => 'Clientes',
        'route' => '/clients',
        'icon' => 'heroicon-users',
        'roles' => ['manager','consultant'],
    ],
    [
        'label' => 'Consultores',
        'route' => '/consultants',
        'icon' => 'heroicon-users',
        'roles' => ['manager'],
    ],
    [
        'label' => 'Contratos',
        'route' => '/contratos',
        'icon' => 'heroicon-document-text',
        'roles' => ['manager'],
    ],
    [
        'label' => 'Faturas',
        'route' => '/faturas',
        'icon' => 'heroicon-ticket',
        'roles' => ['manager'],
    ],
    [
        'label' => 'Planos de cobrança',
        'route' => '/billing-plans',
        'icon' => 'heroicon-currency',
        'roles' => ['manager'],
    ],
    [
        'label' => 'Planos de serviços',
        'route' => '/services-plans',
        'icon' => 'heroicon-tag',
        'roles' => ['manager'],
    ],
    [
        'label' => 'Clientes',
        'route' => '/clients',
        'icon' => 'heroicon-users',
        'roles' => ['agent'],
    ],
    [
        'label' => 'Agentes',
        'route' => '/agents',
        'icon' => 'heroicon-users',
        'roles' => ['client'],
    ],
    [
        'label' => 'Empresas',
        'route' => '/companies',
        'icon' => 'heroicon-modern-house',
        'roles' => ['client'],
    ],
    [
        'label' => 'Financeiro',
        'route' => '/financial',
        'icon' => 'heroicon-currency-dollar',
        'roles' => ['manager'],
    ]
];