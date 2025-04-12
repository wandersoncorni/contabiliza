<?php

use App\AccessControl\Models\User;
use App\AccessControl\Mail\UserCreatedAdminNotification;
use App\Logger\Models\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

it('criar um usuario admin', function () {
    $userData = [
        'email' => 'admin@contabiliza.com.br',
        'name' => 'admin',
        'role' => 'admin'
    ];
    // Loga o usuario
    $admin = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%admin%');
    })->get()->first();

    $this->postJson('/api/v1/login', [
        'email' => $admin->email,
        'password' => 'Password@123',
    ]);

    $response = $this->postJson('/api/v1/register', $userData);
   
    $response->assertStatus(201);
    $this->assertDatabaseHas('users', [
        'email' => $userData['email'],
    ]);
});

it('criar um usuario cliente', function () {
    // Loga o usuario
    $consultor = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->get()->first();

    $consultor->email_verified_at = now();
    $consultor->active = 1;
    $consultor->save();

    $this->postJson('/api/v1/login', [
        'email' => $consultor->email,
        'password' => 'Password@123',
    ]);
    
    $userData = [
        'email' => 'cliente@contabiliza.com.br',
        'name' => 'Cliente',
        'role' => 'client'
    ];

    $response = $this->postJson('/api/v1/register', $userData);
    
    $response->assertStatus(201);

    $cliente = User::where('email', $userData['email'])->first();
    expect($cliente)->not()->toBeNull();
    expect($cliente->person)->not()->toBeNull();
});

it('criar um usuario agente', function () {
    // Loga o usuario
    $cliente = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%admin%');
    })->get()->first();

    $cliente->email_verified_at = now();
    $cliente->active = 1;
    $cliente->save();

    $this->postJson('/api/v1/login', [
        'email' => $cliente->email,
        'password' => 'Password@123',
    ]);
    
    $userData = [
        'email' => 'agente@contabiliza.com.br',
        'name' => 'Agente',
        'role' => 'agent',
        'client_id' => $cliente->id
    ];

    $response = $this->postJson('/api/v1/register', $userData);
    $response->assertStatus(201);
    
    $agente = User::where('email', $userData['email'])->first();
    expect($agente)->not()->toBeNull();
    expect($agente->person)->not()->toBeNull();
});

it('validar o email do usuario', function () {
    $user = User::where('email_verified_at',null)->whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();

    $user->email_verified_at = null;
    $user->save();
    
    URL::forceScheme('https');
    $url = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );
    
    $response = $this->get($url);
    $response->assertStatus(302);
    
    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Password@123',
    ]);
    
    $response->assertStatus(200);
    $this->assertTrue($user->fresh()->hasVerifiedEmail());
});

it('negar criar um usuario', function () {
    $userData = [
        'email' => 'manager@contabiliza.com.br',
        'name' => 'consultant',
        'role' => 'manager'
    ];
    // Loga o usuario
    $consultant = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->get()->first();
    $consultant->email_verified_at = now();
    $consultant->active = 1;
    $consultant->save();

    $this->postJson('/api/v1/login', [
        'email' => $consultant->email,
        'password' => 'Password@123',
    ]);

    $response = $this->postJson('/api/v1/register', $userData);
    $response->assertStatus(403);
});

/**
 * Testa a autenticacao do usuario por outro com permissao de criar usuarios
 * O deverah ser autenticado e a nova contra criada receberah o perfil 
 * de que ele atribuir, menos o de cliente
 */
it('reenvia o email de validação', function () {
    $consultant = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->get()->first();
    $consultant->email_verified_at = now();
    $consultant->active = 1;
    $consultant->save();

    $resp = $this->postJson('/api/v1/login', [
        'email' => $consultant->email,
        'password' => 'Password@123',
    ]);

    Notification::fake();
    $user = User::where('email_verified_at', null)->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();

    $response = $this->postJson('/api/v1/email/resend', [
        'id' => $user->id,
        'email' => $user->email
    ]);

    if (!$user->hasVerifiedEmail()) {
        Notification::assertSentTo($user, VerifyEmail::class);
        $response->assertStatus(200);
    } else {
        $response->assertStatus(400)->assertJson(['error' => 'O e-mail ja foi validado!']);
    }
});

it('pode editar email de outro usuario', function () {
    $consultor = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->get()->first();
    $consultor->email_verified_at = now();
    $consultor->active = 1;
    $consultor->save();
    
    $resp = $this->postJson('/api/v1/login', [
        'email' => $consultor->email,
        'password' => 'Password@123',
    ]);

    $user = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();

    $updateData = [
        'id' => $user->id,
        'email' => 'novo.email@contabiliza.com.br',
    ];

    // Realiza a requisição PUT para atualizar os dados
    $response = $this->putJson('/api/v1/user', $updateData);
    if($response->status() != 200){
        print_r($response->json());
    }    
    // Verifica se a resposta tem status 200 (sucesso na atualização)
   $response->assertStatus(200);
});

it('mudar o estado de ativo/inativo e perfil', function(){
    $admin = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%admin%');
    })->get()->first();
    
    $this->postJson('/api/v1/login', [
        'email' => $admin->email,
        'password' => 'Password@123',
    ]);

    $user = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();

    // Inativa o usuario
    $response = $this->patchJson('/api/v1/user', ['id'=>$user->id,'active'=>0]);
    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'active' => 0
    ]);
});

it('não pode excluir um usuário', function(){
    $consultor = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->get()->first();
    $consultor->email_verified_at = now();
    $consultor->active = 1;
    $consultor->save();
    $this->postJson('/api/v1/login', [
        'email' => $consultor->email,
        'password' => 'Password@123',
    ]);

    $user = User::whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();

    $response = $this->delete('api/v1/user',['id'=>$user->id]);
    $response->assertStatus(403);
});

it('excluir um usuário como admin', function(){
    $admin = User::whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%admin%');
    })->get()->first();

    $user = User::whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();
    
    $this->postJson('/api/v1/login', [
        'email' => $admin->email,
        'password' => 'Password@123',
    ]);  
    
    $response = $this->delete('api/v1/user',['id'=>$user->id]);
    $response->assertStatus(200);
});

it('logar a acao da exclusão por terceiro', function(){
    $log = Log::where('message','Exclusao de usuario')->first();
    expect($log->message)->toMatch('/Exclusao de usuario/');
});
