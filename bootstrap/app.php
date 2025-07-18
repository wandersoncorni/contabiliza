<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api/v1',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Regitar o middleware com alias para aceitar parametros
        $middleware->alias([
            'haspermission' => \App\AccessControl\Http\Middleware\HasPermission::class,
        ]);
        $middleware->statefulApi();
        $middleware->validateCsrfTokens(except: ['api/v1/logout']);
        // Adiciona o middleware para evitar o back history
        $middleware->append(\App\AccessControl\Http\Middleware\PreventBackHistory::class, 'preventBackHistory');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
