
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
    // Rotas para as páginas que somente o admin, manager e o consultant podem ver
    Route::middleware(['haspermission:access.consultant'])->group(function () { 
        Route::get('/financial', function () {
            return view('financial::index');
        })->name('view.financial');

        Route::get('/financial/accounts', function () {
        return view('financial::accounts.index');
        })->name('view.accounts');
    });
});