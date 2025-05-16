<?php

/**
 * Rotas para a aplicação
 */

use App\Application\Http\Controllers\Agent;
use App\Application\Http\Controllers\Client;
use App\Application\Http\Controllers\Consultant;
use App\Application\Http\Controllers\Licensed;
use App\Application\Http\Controllers\Portfolio;
use App\Application\Http\Controllers\ServicePlan;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    /*
     * O usuario deverah ter permissao para a rota para ser executada (action.asset)
     * Para o parametro "asset" da permissao, se houver a "/" no inicio eh uma rota.
     * se nao, eh um recurso
     */
    Route::middleware(['haspermission:access.manager'])->group(function () {
        Route::controller(Portfolio::class)->group(function () {
            Route::get('portfolios', 'list');
            Route::get('portfolio', 'listPortifolio');
            Route::post('portfolio', 'create');
            Route::put('portfolio', 'update');
            Route::delete('portfolio', 'delete');
        });

        Route::get('clients', [Client::class, 'list']);

        Route::get('consultants', [Consultant::class, 'list']);

        Route::get('services-plans', [ServicePlan::class, 'list']);
    });
});
