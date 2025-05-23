<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('/', function () {
        return view('app');
    })->name('view.app');

    Route::get('/painel', function () {
        return view('application::'.session('rule_context').'.index');
    })->name('view.painel');

    Route::middleware(['haspermission:access.admin'])->group(function () { 
        Route::get('/licensed', function () {
            return view('application::admin.licensed');
        })->name('view.licensed');
    });

    Route::middleware(['haspermission:access.manager'])->group(function () { 
        Route::get('/consultants', function () {
            return view('application::manager.consultants');
        })->name('view.consultants');

        Route::get('/clients', function () {
            return view('application::manager.clients');
        })->name('view.clients');

        Route::get('/partners', function () {
            return view('application::manager.partners');
        })->name('view.partners');

        Route::get('/companies', function () {
            return view('application::manager.companies');
        })->name('view.companies');

        Route::get('/agents', function () {
            return view('application::manager.agents');
        })->name('view.agents');

        Route::get('/service-plans', function () {
            return view('application::manager.service-plans');
        })->name('view.service-plans');

        Route::get('/billing-plans', function () {
            return view('application::manager.billing-plans');
        })->name('view.billing-plans');

        Route::get('/portfolios', function () {
            return view('application::manager.portfolios');
        })->name('view.portfolios');
    });

    Route::middleware(['haspermission:access.client'])->group(function () {
        Route::get('/agents', function () {
            return view('application::client.agents');
        })->name('view.agents');

        Route::get('/companies', function () {
            return view('application::client.companies');
        })->name('view.companies');

        Route::get('/partners', function () {
            return view('application::client.partners');
        })->name('view.partners');
        
    });
});
