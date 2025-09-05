<?php

/**
 * Rotas para a aplicação
 */

use App\Application\Http\Controllers\Agent;
use App\Application\Http\Controllers\Auxiliares;
use App\Application\Http\Controllers\CategoriaServico;
use App\Application\Http\Controllers\Client;
use App\Application\Http\Controllers\Cnae;
use App\Application\Http\Controllers\Consultant;
use App\Application\Http\Controllers\FaixaFaturamento;
use App\Application\Http\Controllers\Portfolio;
use App\Application\Http\Controllers\Company;
use App\Application\Http\Controllers\Plano;
use App\Application\Http\Controllers\PlanoServico;
use App\Application\Http\Controllers\Servico;
use App\Application\Http\Controllers\NaturezaJuridica;
use App\Application\Http\Controllers\Partner;
use App\Application\Http\Controllers\PlanoServicoFaixaFaturamento;
use App\Application\Http\Controllers\RegimeBens;
use App\Application\Http\Controllers\RegimeTributario;
use App\Application\Models\AreaAtividade as AreaAtividadeModel;
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
    //Acesso as rotas de agentes, empresas e clientes para o perfil cliente
    Route::middleware(['haspermission:access.client'])->group(function () {
        Route::controller(Agent::class)->group(function () {
            Route::get('agents', 'list');
            Route::post('agent', 'create');
            Route::put('agent/{id?}', 'update');
            Route::delete('agent/{id?}', 'delete');
        });
        //Rotas para criar, editar e cadastrar uma empresa
        Route::controller(Company::class)->group(function () {
            Route::get('companies', 'list');
            Route::get('companies/requests', 'listCompaniesRequests');
            Route::get('company/{id?}', 'listCompany');
            Route::get('company/request/{rid}', 'listCompanyRequest');
            Route::post('company', 'create');
            Route::put('company/{id?}', 'update');
            Route::delete('company/{id?}', 'delete');
            Route::delete('company/request/{rid}', 'deleteCompanyRequest');
            Route::post('company/billing', 'saveBilling');
            Route::put('company/billing', 'updateBilling');
        });
        Route::controller(Partner::class)->group(function () {
            Route::get('partners', 'list');
            Route::get('partners/{eid?}', 'listByCompany');//Lista os socios de uma empresa
            Route::get('partner/{id}', 'listPartner');
            Route::post('partner', 'create');
            Route::put('partner', 'update');
            Route::delete('partner/{id?}', 'delete');
        });
    });
    /*
     * Rotas para usuario autenticado
     */
    Route::controller(PlanoServico::class)->group(function () {
        Route::get('service-plans/{atvid?}', 'list');
        Route::get('service-plan/{pid?}', 'listPlan');
    });

    Route::controller(RegimeBens::class)->group(function () {
        Route::get('regime-bens', 'list');
    });
    //Rota para manter a aplicacao online
    Route::get('live', function () {
        return response()->noContent();
    });

    Route::controller(Cnae::class)->group(function () {
        Route::get('cnaes', 'list');
    });

    Route::get('areas-atividade', function () {
        return AreaAtividadeModel::All();
    })->name('regimes-tributarios.listar');

    /*
     * Rotas auxiliares
     * Essas rotas sao usadas para preencher os selects dos formulários
     */
    Route::get('auxiliares/listar-estado-civil', [Auxiliares::class, 'listarEstadosCivis'])
        ->name('auxiliares.listar-estados-civis');
    Route::get('auxiliares/listar-estados', [Auxiliares::class, 'listarEstados'])
        ->name('auxiliares.listar-estados');
});

Route::controller(Plano::class)->group(function () {
    Route::get('plans', 'list');
});

Route::get('regimes-tributarios', [RegimeTributario::class, 'list'])
    ->name('regimes-tributarios.listar');

//Lista as faixas de faturamento sem os precos
Route::get('faixas-faturamento', [FaixaFaturamento::class, 'list'])
    ->name('faixas-faturamento.listar');
//Lista a faixa de faturamento com os precos dos planos
Route::get('faixas-faturamento/{pid}/{ffid}', [PlanoServicoFaixaFaturamento::class, 'listPlanoFaixaFaturamento'])
    ->name('faixas-faturamento.listar');

Route::get('naturezas-juridicas', [NaturezaJuridica::class, 'list'])
    ->name('naturezas_juridicas.listar');
