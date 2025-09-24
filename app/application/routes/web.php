<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('/', function () {
        return view('app');
    })->name('view.app');

    Route::get('/painel', function () {
        if(session('rule_context') != 'client'){
            return view('admin::'.session('rule_context').'.index');
        }
        return view('application::'.session('rule_context').'.index');
    })->name('view.painel');    

    Route::middleware(['haspermission:access.client'])->group(function () {
        Route::get('/agents', function () {
            return view('application::client.agents');
        })->name('view.agents');

        Route::get('/companies', function () {
            return view('application::client.company.index');
        })->name('view.companies.index');

        Route::get('/partners', function () {
            return view('application::client.partners');
        })->name('view.partners');
        
    });
});
