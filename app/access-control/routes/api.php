<?php

/**
 * Rotas da API para o controle de acesso
 */

use App\AccessControl\Http\Controllers\Account;
use App\AccessControl\Http\Controllers\Authentication;
use App\AccessControl\Http\Controllers\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/******************************************************************
 * Rotas para autenticacao
 ******************************************************************/
Route::controller(Authentication::class)->group(function () {
    Route::post('login', 'login');
    Route::get('logout', 'logout');
});
/******************************************************************
 * Rotas para a aplicacao
 ******************************************************************/
// Rotas para o dominio nao autenticado (dominio publico da aplicacao)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json([], 200);
})->middleware(['auth:sanctum'])->name('email.verify');

Route::controller(Account::class)->group(function () {
    Route::post('account', 'create');
});
// Rotas para o dominio autenticado da aplicacao
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::controller(User::class)->group(function () {
        Route::get('users', [User::class, 'list']);
        Route::get('user', [User::class, 'listUser']);
        Route::put('user/{id?}', [User::class, 'update']);
        Route::patch('user', [User::class, 'changeState']); //Mudar active e profile
        Route::delete('user/{id?}', [User::class, 'delete']);

        Route::post('register', 'create');
        Route::get('password-reset/{token}', 'passwordReset')->name('password.reset');
        Route::get('email-validate/{id}/{token}', 'validateEmail')->name('email.validate');
        Route::post('email/resend', 'emailResend');
    });

    Route::controller(Account::class)->group(function () {
        Route::get('account', 'list');
        Route::put('account', 'update');
        Route::delete('account', 'delete');
    });
});
