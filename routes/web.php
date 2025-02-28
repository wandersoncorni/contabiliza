<?php
/**
 * Rotas para as paginas web
 */
use App\AccessControl\Http\Controllers\Authentication;
use App\AccessControl\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

/*************************************************************
 * Autentiicacao e autorizacao
 *************************************************************/
Route::controller(Authentication::class)->group(function () {
    Route::get('login', function () {
        return view('login');
    })->name('login');
});

/*************************************************************
 * Usuario
 *************************************************************/
Route::get('register', function () {
    return view('register');
})->name('register');

Route::get('forgot-password',  function () {
    return view('forgot.pwd');
});
