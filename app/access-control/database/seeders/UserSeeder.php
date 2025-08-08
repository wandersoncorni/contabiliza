<?php

namespace App\AccessControl\Database\Seeders;

use Illuminate\Database\Seeder;
use App\AccessControl\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Administrador geral da aplicação. Possui acesso a todos os modulos
            [
                'email' => "admin@contabiliza.com.br",
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ],
            // Usuário com acesso adminisrativo. Deve ser associado a um licenciado. Tem acesso a todos os modulos e usuários do licenciado
            [
                'email' => 'manager@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ],
            // Usuário com acesso a a módulos necessários ao seu perfil. Deve ser associado a um licenciado.
            [
                'email' => 'consultant@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ],
            // Usuário cliente. Deve ser associado a um licenciado. Tem acesso a módulos necessários ao seu perfil
            [
                'email' => 'client@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ],
            // Usuário agente licenciado. Deve ser associado a um cliente. Tem acesso a módulos específios do cliente
            [
                'email' => 'agent@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ],
            [
                'email' => 'client2@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => null,
                'active' => 1
            ],
        ];
        foreach ($data as $item) {
            User::factory()->create($item);
        }
    }
}
