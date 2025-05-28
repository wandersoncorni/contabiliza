<?php

namespace Tests\AccessControl;

use App\AccessControl\Models\User;
use App\Application\Models\Person;
use App\Logger\Models\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_uma_conta(): void
    {
        $response = $this->postJson('/api/v1/account', [
            'name' => 'Cliente Teste',
            'email' => 'teste@example.com',
            'password' => 'Senha@123',
            'password_confirmation' => 'Senha@123',
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'teste@example.com')->first();
        $this->assertNotNull($user);

        $person = Person::where('id_user', $user->id)->first();
        $this->assertNotNull($person);

        $log = Log::where('message', 'Usuário criado com sucesso.')->first();
        $this->assertNotNull($log);
    }

    public function test_validar_email_do_usuario(): void
    {
        $cliente = User::where('email', 'teste@example.com')->whereHas('person')->first();

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
    }

    public function test_editar_a_conta(): void
    {
        $cliente = User::where('email', 'teste@example.com')->whereHas('person')->first();

        $this->postJson('/api/v1/login', [
            'email' => $cliente->email,
            'password' => 'Senha@123',
        ]);

        $response = $this->putJson('/api/v1/account', [
            'name' => 'Novo Nome',
            'email' => 'novo_email@me.com',
            'password' => 'Novasenha@123',
            'password_confirmation' => 'Novasenha@123',
            'current_password' => 'Senha@123',
        ]);

        $response->assertStatus(200);

        $cliente->refresh();
        $this->assertEquals('Novo Nome', $cliente->person->name);
        $this->assertEquals('novo_email@me.com', $cliente->email);
        $this->assertTrue(Hash::check('Novasenha@123', $cliente->password));
    }

    public function test_excluir_a_conta(): void
    {
        $cliente = User::where('email', 'novo_email@me.com')->whereHas('person')->first();
        $uid = $cliente->id;

        $this->postJson('/api/v1/login', [
            'email' => $cliente->email,
            'password' => 'Novasenha@123',
        ]);

        $response = $this->deleteJson('/api/v1/account');
        $response->assertStatus(200);

        $this->assertNull(User::find($uid));
        $this->assertNull(Person::where('id_user', $uid)->first());
        $this->assertNotNull(Log::where('message', 'Exclusão da conta pelo usuário')->first());
    }
}
