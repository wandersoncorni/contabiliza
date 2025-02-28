<?php

/**
 * Classe de teste para App\AcessControl\Controllers\AuthController
 * @version 1.0.0
 * @author Wanderson Corni <wandersoncorni@gmail.com>
 */

use App\AccessControl\Models\User;

/**
 * Testa a exibição da tela de login
 */
it('exibir a tela de login', function () {
    $response = $this->get('login');

    $response->assertStatus(200);
});
/**
 * Testa o login de um usuario
 * Condição: O usuario deve estar cadastrado no sistema
 */
it('executa o login um usuario', function () {
    $user = User::first();
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

    $response->assertStatus(200);
});
