<?php
/**
 * Rotas para as paginas do controle de acesso
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*************************************************************
 * Autentiicacao e autorizacao
 *************************************************************/

Route::get('login', function () {
    return view('access-control::login');
})->name('login');

/*************************************************************
 * Usuario
 *************************************************************/
Route::get('register', function () {
    return view('access-control::register');
})->name('register.view');

Route::get('forgot-password',  function () {
    return view('access-control::forgot-password');
})->name('forgot-password.view');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
})->middleware(['auth:sanctum'])->name('verification.send');

Route::get('/email/verify', function (Request $request) {
    session(['verify' => $request->all()]);
    return redirect('/login');
})->name('verification.verify');