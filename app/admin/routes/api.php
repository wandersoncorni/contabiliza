<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Http\Controllers\CategoriaServico;
use App\Admin\Http\Controllers\Client;
use App\Admin\Http\Controllers\Consultant;
use App\Admin\Http\Controllers\Portfolio;
use App\Admin\Http\Controllers\Servico;
/*
 * Rotas para a área administrativa da API
 * Todas as rotas abaixo precisam estar autenticadas e para assegurar que estejam, deve ser
 * adiocionadas abaixo das regras de middleaware do sanctum e verified. O sanctum verifica a autenticacao
 * da sessão do usuario e o verified verifica se o usuario possui um email verificado
 * Para adicionar um novo conjunto de rotas sob regras de middleaware, use o middleware "haspermission"
 * seguida do parmetro do perfil que se deseja que tenha acesso
 * Lembrando que o perfil é hierárquico.
 */
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Rotas para as páginas que somente o admin e o manager podem ver
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
            Route::post('service-plan', 'create');
            Route::put('service-plan', 'update');
            Route::delete('service-plan/{id?}', 'delete');
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
});