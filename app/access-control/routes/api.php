<?php
/**
 * Rotas da API para o controle de acesso
 */

use App\AccessControl\Http\Controllers\Account;
use App\Application\Http\Controllers\Application;
use App\AccessControl\Http\Controllers\Authentication;
use App\AccessControl\Http\Controllers\User;
use App\AccessControl\Http\Controllers\Role;
use App\Application\Http\Controllers\Licensed;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/******************************************************************
 * Rotas para autenticacao
 ******************************************************************/
Route::post('login', [Authentication::class, 'login'])->name('api.login');

/******************************************************************
 * Rotas para a aplicacao
 ******************************************************************/
// Rotas para o dominio nao autenticado (dominio publico da aplicacao)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json([], 200);
})->middleware(['auth:sanctum'])->name('email.verify');

Route::post('account', [Account::class, 'create'])->name('account.create');

Route::post('forgot-password', [Account::class, 'forgotPassword'])->name('forgot.password');

Route::get('/email/verify', function (Request $request) {
    session(['verify' => $request->all()]);
    return response()->json([], 200);
})->name('verification.verify');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::controller(Application::class)->group(function () {
        Route::get('painel', 'listarPainel');
    });
    Route::controller(Authentication::class)->group(function () {
        Route::post('logout', 'logout');
    });
    Route::controller(Account::class)->group(function () {
        Route::get('account', fn () => view('application::account'));
        Route::get('account/list', 'list');
        Route::put('account', 'update');
        Route::delete('account', 'delete');
    });
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    /*
     * Os perfis admin, manager, consultant e client poderao criar uuarios em
     * decorrencia da necessidade de cada um.
     */
    Route::controller(User::class)->group(function () {
        Route::get('users', 'list');        
        Route::post('user', 'create');        
        Route::delete('user/{id?}', 'delete');
    });
    /*
     * Somente os perfis admin, manager e consutant poderao atualizar usuarios, sendo
     * que o admin podera atualizar todos os usuarios, enquanto o manager e o consultant
     * poderao atualizar apenas os usuarios que forem criados no seu dominio de permissao de uso.
     */
    Route::controller(User::class)->group(function () {        
        Route::get('user', 'listUser');
        Route::put('user/{id?}', 'update');
        Route::patch('user', 'changeState'); //Mudar active e profile

        Route::get('password-reset/{token}', 'passwordReset')->name('password.reset');
        Route::get('email-validate/{id}/{token}', 'validateEmail')->name('email.validate');
        Route::post('email/resend', 'emailResend');
        
        Route::get('roles', [Role::class, 'list'])->name('roles.list');
    })->middleware(['haspermission:access.users_route']);
});

// Rotas para o dominio autenticado da aplicacao
Route::middleware(['auth:sanctum', 'verified', 'haspermission:access.admin'])->group(function () {
    Route::controller(Role::class)->group(function () {
        Route::get('role', 'listRole');
        Route::post('role', 'create');
        Route::put('role/{id?}', 'update');
        Route::delete('role/{id?}', 'delete');
    });
});
