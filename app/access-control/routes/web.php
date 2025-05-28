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
// Rota para o registro de usuario. O pid é i identificador do plano de serviço escolhido
Route::get('register/{pid?}', function () {
    session('pid', request('pid'));
    return view('access-control::register');
})->name('register.view');

Route::get('forgot-password',  function () {
    return view('access-control::forgot-password');
})->name('forgot-password.view');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
})->middleware(['auth:sanctum'])->name('verification.send');

Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::get('account', function () {
    return view('access-control::account');
})->name('view.account');

Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('users', function () {
        return view('access-control::users');
    })->name('view.users');
});