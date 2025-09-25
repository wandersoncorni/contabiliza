
<?php

use Illuminate\Support\Facades\Route;
/*
 * Rotas web para a área administrativa
 * Somente os perfis admin, manager e consultant poderao acessar
 * O RBAC é hierárquico, portanto do perfil de visibilidade a ser
 * usado na proteção da rota deve ser daquele que se deseja que tenha acesso
 * lembrando que o perfil de nível superior terá os mesmos acessos de seus
 * perfis inferiores
 */
Route::middleware(['auth:sanctum','verified'])->group(function () {
    /*
     * Rotas para as páginas que somente o admin pode ver
     */
    Route::middleware(['haspermission:access.admin'])->group(function () { 
        Route::get('/licensed', function () {
            return view('admin::admin.licensed');
        })->name('view.licensed');
    });
    // Rotas para as páginas que somente o admin e o manager podem ver
    Route::middleware(['haspermission:access.manager'])->group(function () { 
        Route::get('/consultants', function () {
            return view('application::manager.consultants');
        })->name('view.consultants');

        Route::get('/clients', function () {
            return view('application::manager.clients');
        })->name('view.clients');

        Route::get('/partners', function () {
            return view('application::manager.partners');
        })->name('view.partners');

        Route::get('/agents', function () {
            return view('application::manager.agents');
        })->name('view.agents');

        Route::get('/services-plans', function () {
            return view('application::manager.services-plans.index');
        })->name('view.services-plans');

        Route::get('/billing-plans', function () {
            return view('application::manager.billing-plans');
        })->name('view.billing-plans');

        Route::get('/clients-portfolios', function () {
            return view('application::manager.portfolios');
        })->name('view.portfolios');
    });
});