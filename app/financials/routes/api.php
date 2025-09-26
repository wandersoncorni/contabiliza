<?php

use Illuminate\Support\Facades\Route;
use App\Financial\Http\Controllers\AccountController;
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
    // Rotas para funcionalidades da API relativas as funções o perfil de consultor
    Route::middleware(['haspermission:access.consultant'])
        ->controller(AccountController::class)
        ->group(function () {
            Route::get('accounts', 'index')->name('api.accounts.index');
            Route::get('accounts/{id}', 'show')->name('api.accounts.show');
            Route::post('accounts', 'store')->name('api.accounts.store');
            Route::put('accounts/{id}', 'update')->name('api.accounts.update');
            Route::delete('accounts/{id}', 'destroy')->name('api.accounts.destroy');
    });
});