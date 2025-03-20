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

Route::get('login', function () {
    return view('access-control::login');
})->name('login.view');

/*************************************************************
 * Usuario
 *************************************************************/
Route::get('register', function () {
    return view('access-control::register');
})->name('register.view');

Route::get('forgot-password',  function () {
    return view('forgot.pwd.view');
});
