<?php

/**
 * Classe de teste para App\AcessControl\Controllers\AuthController
 * @version 1.0.0
 * @author Wanderson Corni <wandersoncorni@gmail.com>
 */

use App\AccessControl\Models\User;
use Illuminate\Support\Facades\Auth;

it('nao executa o login de um usuario com email nao verificado', function () {
    $user = User::where('email_verified_at', null)->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->first();
    
    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Senha@123',
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
        'password' => 'Senha@123',
    ]);

    $response->assertStatus(403)
        ->assertJson(['error' => 'Conta inativa! Verifique seu email ou informe ao administrador.']);
});

it('executa o login  de um usuario ativo e email verificado', function () {
    $user = User::first();
    $user->email_verified_at = now();
    $user->active = 1;
    $user->save();
    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Senha@123',
    ]);

    $response->assertStatus(200);
    expect(Auth::user())->not()->toBeNull();
});
/**
 * Testa o logout de um usuario
 */
it('executa o logout de um usuário', function () {
    $user = User::first();
    $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Senha@123',
    ]);

    $response = $this->postJson('/api/v1/logout',[]);
    $response->assertStatus(200);
});
