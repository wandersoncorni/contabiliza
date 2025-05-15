<?php

/**
 * Rotas para a aplicação
 */

use App\Application\Http\Controllers\Agent;
use App\Application\Http\Controllers\Client;
use App\Application\Http\Controllers\Consultant;
use App\Application\Http\Controllers\Licensed;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    /*
     * O usuario deverah ter permissao para a rota para ser executada (action.asset)
     * Para o parametro "asset" da permissao, se houver a "/" no inicio eh uma rota.
     * se nao, eh um recurso
     */
    Route::middleware(['haspermission:access./licensed'])
        ->controller(Licensed::class)->group(function () {
            Route::get('licensed', 'list');
            Route::get('licensed/{id}', 'listLicensed');
        });

    Route::middleware(['haspermission:access./consultants'])
        ->controller(Consultant::class)->group(function () {
            Route::get('consultants', 'list');
            Route::get('consultant', 'listConsultant');
        });

    Route::middleware(['haspermission:access./consultants'])
        ->controller(Client::class)->group(function () {
            Route::get('clients', 'list');
        });

    Route::middleware(['haspermission:access./agents'])
        ->controller(Agent::class)->group(function () {
            Route::get('agents', 'list');
        });
});
