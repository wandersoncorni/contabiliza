<?php

/**
 * Rotas para a aplicação
 */

use App\Application\Http\Controllers\Agent;
use App\Application\Http\Controllers\Auxiliares;
use App\Application\Http\Controllers\Cnae;
use App\Application\Http\Controllers\FaixaFaturamento;
use App\Application\Http\Controllers\Company;
use App\Application\Http\Controllers\Plano;
use App\Application\Http\Controllers\PlanoServico;
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
            Route::get('company/{id?}', 'listCompany');
            Route::get('company/request/{rid}', 'listCompanyRequest');
            Route::get('company/billing/{empresa_id}', 'listCompanyBilling');
            Route::post('company', 'create');
            Route::put('company/{id?}', 'update');

            Route::put('company-billing', 'saveBilling');
            Route::post('company-billing', 'saveBilling');

            Route::post('company-payment', 'savePayment');
            Route::put('company-payment', 'savePayment');

            Route::delete('company/{id?}', 'delete');
        });
        Route::controller(Partner::class)->group(function () {
            Route::get('partners', 'list');
            Route::get('partners/{eid?}', 'listByCompany');//Lista os socios de uma empresa
            Route::get('partner/{id}', 'listPartner');
            Route::get('partner-search', 'searchPartner');
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
/*
 * Rotas para usuario nao autenticado
 * São rotas para listas de dados que nao precisam de autenticacao
 */
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
