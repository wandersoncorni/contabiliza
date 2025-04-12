<?php
/**
 * Rotas para a aplicação
 */
use App\Application\Http\Controllers\Client;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum', 'hasPermission:admin,client'])->group(function () {    
//     Route::controller(Client::class)->group('client', function () {
//         Route::get('clients', 'list');
//         Route::post('client', 'create');
//         Route::put('client', 'update');
//         Route::delete('client/{id?}', 'delete');
//     });
// });