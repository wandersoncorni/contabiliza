<?php
return [
    'paths' => ['api/v1/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Coloque a URL da sua SPA
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'supports_credentials' => true, // IMPORTANTE para permitir cookies
];