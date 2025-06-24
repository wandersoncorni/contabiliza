<?php

/**
 * Rotas para a aplicação
 */

use App\Application\Http\Controllers\Agent;
use App\Application\Http\Controllers\CategoriaServico;
use App\Application\Http\Controllers\Client;
use App\Application\Http\Controllers\Consultant;
use App\Application\Http\Controllers\Portfolio;
use App\Application\Http\Controllers\Company;
use App\Application\Http\Controllers\Plano;
use App\Application\Http\Controllers\PlanoServico;
use App\Application\Http\Controllers\Servico;
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

        Route::controller(Plano::class)->group(function () {
            Route::post('plano', 'create');
            Route::delete('plano/{id?}', 'delete');
        });

        Route::controller(PlanoServico::class)->group(function () {
            Route::get('planos-servicos', 'list');
            Route::post('plano-servico', 'create');
            Route::put('plano-servico/{id?}', 'update');
            Route::delete('plano-servico/{id?}', 'delete');
        });

        Route::controller(CategoriaServico::class)->group(function () {
            Route::get('categorias-servicos', 'list');
            Route::get('categorias-e-servicos', 'listCategoriesAndServices');
            Route::post('categoria-servico', 'create');
            Route::put('categoria-servico/{id?}', 'update');
            Route::delete('categoria-servico/{id?}', 'delete');
            Route::delete('categoria-plano/{pid}/{cid}', 'deleteCategoryPlan');
        });

        Route::controller(Servico::class)->group(function () {
            Route::get('servicos', 'list');
            Route::post('servico', 'create');
            Route::put('servico/{id?}', 'update');
            Route::delete('servico/{id?}', 'delete');
            Route::delete('servico-plano/{pid}/{cid}/{sid}', 'excluirServicoPlano');
        });
    });

    Route::middleware(['haspermission:access.client'])->group(function () {
        Route::controller(Agent::class)->group(function () {
            Route::get('agents', 'list');
            Route::post('agent', 'create');
            Route::put('agent/{id?}', 'update');
            Route::delete('agent/{id?}', 'delete');
        });

        Route::controller(Company::class)->group(function () {
            Route::get('companies', 'list');
            Route::post('company', 'create');
            Route::put('company/{id?}', 'update');
            Route::delete('company/{id?}', 'delete');
        });
    });
});

Route::controller(Plano::class)->group(function () {
    Route::get('plans', 'list');
});
