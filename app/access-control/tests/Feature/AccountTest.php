<?php

require __DIR__ . '../../Pest.php';

use App\AccessControl\Models\User;
use App\Application\Models\Person;
use App\Logger\Models\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

it('Cria uma conta', function () {
    echo get_class($this);
    $response = $this->postJson('/api/v1/account', [
        'name' => 'Cliente Teste',
        'email' => 'teste@example.com',
        'password' => 'Senha@123',
        'password_confirmation' => 'Senha@123',
    ]);

    $response->assertStatus(201);
  
    // Verifica se a conta foi criada
    $user = User::where('email', 'teste@example.com')->first();
    $this->assertNotNull($user);

    $person = Person::where('user_id', $user->id)->first();
    $this->assertNotNull($person);
    // Verifica se o log foi criado
    expect(Log::where('message','Usuário criado com sucesso.')->first())->not()->toBeNull();
});

it('validar o email do usuario', function () {
    $cliente = User::where('email','teste@example.com')->whereHas('person')->first();
        
    URL::forceScheme('https');
    $url = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $cliente->id, 'hash' => sha1($cliente->email)]
    );
    
    $response = $this->get($url);
    $response->assertStatus(200);
    
    $response = $this->postJson('/api/v1/login', [
        'email' => $cliente->email,
        'password' => 'Senha@123',
    ]);
    
    $response->assertStatus(200);
    $this->assertTrue($cliente->fresh()->hasVerifiedEmail());
});

it('editar a conta', function () {
    $cliente = User::where('email','teste@example.com')->whereHas('person')->first();

    $login = $this->postJson('/api/v1/login', [
        'email' => $cliente->email,
        'password' => 'Senha@123',
    ]);

    $response = $this->putJson('/api/v1/account', [
        'name' => 'Novo Nome',
        'email' => 'novo_email@me.com', 
        'password' => 'Novasenha@123',
        'password_confirmation'=> 'Novasenha@123',
        'current_password' => 'Senha@123',
    ]);

    $response->assertStatus(200);

    $cliente->refresh();
    $this->assertEquals('Novo Nome', $cliente->person->name);
    $this->assertEquals('novo_email@me.com', $cliente->email);
    $this->assertTrue(Hash::check('Novasenha@123', $cliente->password));
});

it('excluir a conta', function(){
    $cliente = User::where('email','novo_email@me.com')->whereHas('person')->first();
    $uid = $cliente->id;
    $pid = $cliente->person->id;

    $this->postJson('/api/v1/login', [
        'email' => $cliente->email,
        'password' => 'Novasenha@123',
    ]);
    
    $response = $this->deleteJson('api/v1/account');
    $response->assertStatus(200);
    // Verifica se a conta foi realmente excluida
    expect(User::where('id', $uid)->first())->toBeNull();
    expect(Person::where('user_id', $uid)->first())->toBeNull();
    // Verifica se o log foi criado
    expect(Log::where('message','Exclusão da conta pelo usuário')->first())->not()->toBeNull();
});