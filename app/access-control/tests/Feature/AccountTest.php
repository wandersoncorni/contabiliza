<?php
use App\AccessControl\Models\User;
use \App\Application\Models\People;
use \App\Application\Models\Client;
use App\Logger\Models\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

it('Cria uma conta', function () {
    $response = $this->postJson('/api/v1/account', [
        'name' => 'Teste',
        'email' => 'teste@example.com',
        'password' => 'Senha@123',
        'password_confirmation' => 'Senha@123',
    ]);
    
    $response->assertStatus(201);
    // Verifica se a conta foi criada
    $user = User::where('email', 'teste@example.com')->first();
    $this->assertNotNull($user);

    $people = People::where('user_id', $user->id)->first();
    $this->assertNotNull($people);

    $cliente = Client::where('people_id', $people->id)->first();
    $this->assertNotNull($cliente);
    // Verifica se o log foi criado
    expect(Log::where('message','Usuário criado com sucesso.')->first())->not()->toBeNull();
});

it('excluir a conta', function(){
    $cliente = User::where('email','teste@example.com')->whereHas('person')->get()->first();
    
    $cliente->email_verified_at = now();
    $cliente->active = 1;
    $cliente->save();

    $uid = $cliente->id;
    $pid = $cliente->person->id;

    $this->postJson('/api/v1/login', [
        'email' => $cliente->email,
        'password' => 'Senha@123',
    ]);
    
    $response = $this->deleteJson('api/v1/account',['password'=>'Senha@123']);
    $response->assertStatus(200);
    // Verifica se a conta foi realmente excluida
    expect(User::where('id', $uid)->first())->toBeNull();
    expect(People::where('user_id', $uid)->first())->toBeNull();
    expect(Client::where('people_id', $pid)->first())->toBeNull();
    // Verifica se o log foi criado
    expect(Log::where('message','Exclusão da conta pelo usuário')->first())->not()->toBeNull();
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

it('editar a conta', function () {
    $user = User::whereHas('person',function($query){
        $query->where('roles', 'LIKE', '%client%');
    })->get()->first();

    $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'Password@123',
    ]);

    $response = $this->putJson('/api/v1/account', [
        'name' => 'Novo Nome',
        'email' => 'novo_email@me.com', 
        'password' => 'Novasenha@123',
        'password_confirmation'=> 'Novasenha@123',
        'current_password' => 'Password@123',
    ]);

    $response->assertStatus(200);

    $user->refresh();
    $this->assertEquals('Novo Nome', $user->person->name);
    $this->assertEquals('novo_email@me.com', $user->email);
    $this->assertTrue(Hash::check('Novasenha@123', $user->password));
});