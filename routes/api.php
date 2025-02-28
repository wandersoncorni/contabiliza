<?php
/**
 * Rotas da API
 */
use App\AccessControl\Http\Controllers\Authentication;
use App\AccessControl\Http\Controllers\User;
use Illuminate\Support\Facades\Route;
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
    Route::post('register',[User::class, 'createClient']);
    Route::post('forgot-password', 'forgotPassword');    
    Route::get('email-validate/{id}/{token}', 'validateEmail')->name('email.validate');
});
// Rotas para o dominio autenticado da aplicacao
Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(User::class)->group(function () {
        Route::get('users',[User::class, 'list']);
        Route::get('user',[User::class, 'listUser']);
        Route::put('user/{id?}',[User::class, 'update']);
        Route::patch('user',[User::class, 'changeState']);//Mudar active e profile
        Route::delete('user/{id?}',[User::class, 'delete']);
        Route::get('send-email-validation/{id}/{email}', 'sendEmailValidation')->name('send.email.validation');
    });
});