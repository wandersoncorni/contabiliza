<?php
/**
 * Rotas da API
 */
use App\AccessControl\Http\Controllers\Authentication;
use App\AccessControl\Http\Controllers\User;
use App\Application\Http\Controllers\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
Route::controller(User::class)->group(function () {
    Route::post('register', 'create');
    Route::post('forgot-password', 'forgotPassword');
    Route::post('email/resend', 'emailResend');
    Route::get('email/verify/{id}/{hash}', 'verify')->name('verification.verify');
});
// Rotas para o dominio autenticado da aplicacao
Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::controller(User::class)->group(function () {
        Route::get('users',[User::class, 'list']);
        Route::get('user',[User::class, 'listUser']);
        Route::put('user/{id?}',[User::class, 'update']);
        Route::patch('user',[User::class, 'changeState']);//Mudar active e profile
        Route::delete('user/{id?}',[User::class, 'delete']);
    });
});

// Route::middleware(['auth:sanctum', 'hasPermission:admin,client'])->group(function () {    
//     Route::controller(Client::class)->group('client', function () {
//         Route::get('clients', 'list');
//         Route::post('client', 'create');
//         Route::put('client', 'update');
//         Route::delete('client/{id?}', 'delete');
//     });
// });