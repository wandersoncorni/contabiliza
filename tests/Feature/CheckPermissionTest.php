<?php

use App\AccessControl\Models\User;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\actingAs;

/*
 * Teste de heranca de permissoes
 * O perfil "root" eh o topo da hierarquia,, porem o Laminas RBAC tem heranca descendente, onde o
 * filho herda as permissoes do pai. Porem esse comportamento nao eh o indicado, ja que em sistemas
 * de informacao o topo possui autorizacao para tudo e os demais conforme seu papel no sistema
 */
it('permite o root criar um registro', function () {
    $user = User::factory()->create();
    $user->roles = ["root"];
    // Definir uma rota temporária protegida pelo middleware
    Route::middleware(['haspermission:create.user'])->get('/middleware-test', function () {
        return response()->json(['message' => 'Acesso permitido'], 200);
    });

    // Fazer a requisição autenticada
    $response = actingAs($user)->get('/middleware-test');

    // Verificar se o acesso foi permitido
    $response->assertStatus(200)->assertJson(['message' => 'Acesso permitido']);
});

it('permite o admin criar um registro', function () {
    $user = User::factory()->create();
    $user->roles = ["admin"];
    // Definir uma rota temporária protegida pelo middleware
    Route::middleware(['haspermission:create.user'])->get('/middleware-test', function () {
        return response()->json(['message' => 'Acesso permitido'], 200);
    });

    // Fazer a requisição autenticada
    $response = actingAs($user)->get('/middleware-test');

    // Verificar se o acesso foi permitido
    $response->assertStatus(200)->assertJson(['message' => 'Acesso permitido']);
});


it('não permite o usuario criar um registro', function () {
    $user = User::factory()->create();
    $user->roles = ["consultant"];
    // Definir uma rota temporária protegida pelo middleware
    Route::middleware(['haspermission:create.user'])->get('/middleware-test', function () {
        return response()->json(['message' => 'Acesso permitido'], 200);
    });

    // Fazer a requisição autenticada
    $response = actingAs($user)->get('/middleware-test');

    // Verificar se o acesso foi permitido
    $response->assertStatus(403)->assertJson(['error' => 'Permissão negada.']);
});