<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('/', function () {
        return view('app');
    })->name('view.app');

    Route::get('/painel', function () {
        return view('application::painel.'.session('rule_context'));
    })->name('view.painel');

    Route::middleware(['haspermission:access./licensed'])->get('/licensed', function () {
        return view('application::licensed.index');
    })->name('view.licensed');

    Route::middleware(['haspermission:access./consultants'])->get('/consultants', function () {
        return view('application::consultants.index');
    })->name('view.consultants');

    Route::middleware(['haspermission:access./clients'])->group(function () {
        Route::get('/clients', function () {
            return view('application::clients.index');
        })->name('view.clients');

        Route::get('/companies', function () {
            return view('application::companies.index');
        })->name('view.companies');

        Route::get('/partners', function () {
            return view('application::partners.index');
        })->name('view.partners');
    });

    Route::middleware(['haspermission:access./agents'])->get('/agents', function () {
        return view('application::agents.index');
    })->name('view.agents');


});
