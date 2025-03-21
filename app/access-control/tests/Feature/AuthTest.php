<?php

/**
 * Classe de teste para App\AcessControl\Controllers\AuthController
 * @version 1.0.0
 * @author Wanderson Corni <wandersoncorni@gmail.com>
 */

use App\AccessControl\Models\User;

it('nao executa o login um usuario com email nao verificado', function () {
    $user = User::whereHas('people', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Password@123',
    ]);
    
    $response->assertStatus(403)
        ->assertJson(['error' => 'Verifique seu e-mail antes de fazer login.']);
});

it('nao executa o login um usuario desativado', function () {
    $user = User::first();
    $user->email_verified_at = now();
    $user->active = 0;
    $user->save();
    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Password@123',
    ]);

    $response->assertStatus(403)
        ->assertJson(['error' => 'Conta inativa! Verifique seu email ou informe ao administrador.']);
});

/**
 * Testa o login de um usuario
 * Condição: 
 *  - O usuario deve estar cadastrado no sistema
 *  - O email devee ser valido
 *  - O usuario deve estar ativo
 */
it('executa o login um usuario ativo e email verificado', function () {
    $user = User::first();
    $user->email_verified_at = now();
    $user->active = 1;
    $user->save();
    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Password@123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);
});
/**
 * Testa o logout de um usuario
 */
it('executa o logout de um usuário', function () {
    $user = User::first();
    $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Password@123',
    ]);

    $response = $this->get('/api/v1/logout');

    $response->assertStatus(302);
});
