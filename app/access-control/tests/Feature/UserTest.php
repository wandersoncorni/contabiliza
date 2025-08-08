<?php

use App\AccessControl\Models\User;
use App\Logger\Models\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

it('criar um usuario admin', function () {
    $userData = [
        'email' => 'outro.admin@contabiliza.com.br',
        'name' => 'outro.admin',
        'role' => 'admin'
    ];
    
    $admin = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%admin%');
    })->first();

    $this->postJson('/api/v1/login', [
        'email' => $admin->email,
        'password' => 'Senha@123',
    ]);

    $response = $this->postJson('/api/v1/user', $userData);
    $response->assertStatus(201);
    $this->assertDatabaseHas('users', ['email' => $userData['email']]);
});

it('criar um usuario cliente', function () {
    $consultor = User::whereNotNull('email_verified_at')->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->first();

    $response = $this->postJson('/api/v1/login', [
        'email' => $consultor->email,
        'password' => 'Senha@123',
    ]);
    $response->assertStatus(200);
    
    $userData = [
        'email' => 'cliente2@contabiliza.com.br',
        'name' => 'Cliente',
        'role' => 'client'
    ];

    $response = $this->postJson('/api/v1/user', $userData);
    $response->assertStatus(201);

    $cliente = User::where('email', $userData['email'])->first();
    expect($cliente)->not()->toBeNull();
    expect($cliente->person)->not()->toBeNull();
});

it('criar um usuario agente', function () {
    $cliente = User::whereNotNull('email_verified_at')->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->first();

    $respo = $this->postJson('/api/v1/login', [
        'email' => $cliente->email,
        'password' => 'Senha@123',
    ]);

    $userData = [
        'email' => 'agente2@contabiliza.com.br',
        'name' => 'Agente',
        'role' => 'agent',
    ];

    $response = $this->postJson('/api/v1/user', $userData);
    $response->assertStatus(201);
    
    $agente = User::where('email', $userData['email'])->first();
    expect($agente)->not()->toBeNull();
    expect($agente->person)->not()->toBeNull();
});

it('validar o email do usuario', function () {
    $user = User::whereNull('email_verified_at')->whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%client%');
    })->first();
    
    URL::forceScheme('https');
    $url = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );
    
    $response = $this->get($url);
    $response->assertStatus(200);
    
    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Senha@123',
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
    $consultant = User::whereNotNull('email_verified_at')->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->first();

    $this->postJson('/api/v1/login', [
        'email' => $consultant->email,
        'password' => 'Senha@123',
    ]);

    $response = $this->postJson('/api/v1/user', $userData);
    $response->assertStatus(403)->assertJson(['error' => 'Você nao tem permissão para criar um usuario com o perfil selecionado.']);
});

it('reenvia o email de validação', function () {
    $consultant = User::whereNotNull('email_verified_at')->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->first();

    $resp = $this->postJson('/api/v1/login', [
        'email' => $consultant->email,
        'password' => 'Senha@123',
    ]);

    Notification::fake();
    $user = User::where('email_verified_at', null)->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->first();

    $response = $this->postJson('/api/v1/email/resend', [
        'id' => $user->id,
        'email' => $user->email
    ]);

    Notification::assertSentTo($user, VerifyEmail::class);
    $response->assertStatus(200);
});

it('pode editar email de outro usuario', function () {
    $consultor = User::whereNotNull('email_verified_at')->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->first();
    
    $resp = $this->postJson('/api/v1/login', [
        'email' => $consultor->email,
        'password' => 'Senha@123',
    ]);

    $user = User::whereNull('email_verified_at')->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%client%');
    })->first();

    $updateData = [
        'id' => $user->id,
        'email' => 'novo.email@contabiliza.com.br',
    ];

    $response = $this->putJson('/api/v1/user', $updateData);
    if($response->status() != 200){
        print_r($response->json());
    }
    
    $response->assertStatus(200);
});

it('mudar o estado de ativo/inativo e perfil', function(){
    $admin = User::whereNotNull('email_verified_at')->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%admin%');
    })->first();
    
    $this->postJson('/api/v1/login', [
        'email' => $admin->email,
        'password' => 'Senha@123',
    ]);

    $user = User::whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%agent%');
    })->first();

    $response = $this->patchJson('/api/v1/user', ['id'=>$user->id,'active'=>0]);
    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'active' => 0
    ]);
});

it('não pode excluir um usuário', function(){
    $consultor = User::whereNotNull('email_verified_at')->whereHas('person', function ($query) {
        $query->where('roles', 'LIKE', '%consultant%');
    })->first();
    
    $this->postJson('/api/v1/login', [
        'email' => $consultor->email,
        'password' => 'Senha@123',
    ]);

    $user = User::whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%client%');
    })->first();

    $response = $this->delete('api/v1/user',['id'=>$user->id]);
    $response->assertStatus(403);
});

it('excluir um usuário agente como cliente', function(){
    $cliente = User::whereNotNull('email_verified_at')->whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%client%');
    })->first();
    
    $agente = User::whereHas('person',function($query)use($cliente){
        $query->where('roles', 'LIKE', '%agent%')->where('client_id', '=', $cliente->person->id);
    })->first();
    
    $this->postJson('/api/v1/login', [
        'email' => $cliente->email,
        'password' => 'Senha@123',
    ]);
    
    $response = $this->delete('api/v1/user',['id'=>$agente->id]);
    $response->assertStatus(200);

    $log = Log::where('message','Exclusao de usuario')->first();
    expect($log->message)->toMatch('/Exclusao de usuario/');
});

it('excluir um usuário cliente como gerente', function(){
    $manager = User::whereNotNull('email_verified_at')->whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%manager%');
    })->first();

    $user = User::whereHas('person',function($query){
        $query->where([['roles', 'LIKE', '%client%'], ['licensed_id', '=', 1]]);
    })->first();
    
    $resp = $this->postJson('/api/v1/login', [
        'email' => $manager->email,
        'password' => 'Senha@123',
    ]); 
    $response = $this->delete('api/v1/user',['id'=>$user->id]);
    $response->assertStatus(200);

    $log = Log::where('message','Exclusao de usuario')->first();
    expect($log->message)->toMatch('/Exclusao de usuario/');
});