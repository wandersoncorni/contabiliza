<?php

namespace Database\Seeders;

use App\AccessControl\Models\User;
use App\Application\Models\Person;
use App\Application\Models\Licensed;
use App\Application\Models\Empresa;
use App\Application\Models\PlanoServicoContratado;
use App\AccessControl\Database\Seeders\RbacSeeder;
use App\Application\Database\Seeders\PlanosSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $licensed = Licensed::factory()->create([
            'name' => 'Contabiliza',
        ]);
        $licensed2 = Licensed::factory()->create([
            'name' => 'licensed 2',
        ]);

        // Cria um admininistrador validado
        $admin = User::factory()->create([
            'email' => "admin@contabiliza.com.br",
            'password' => 'Senha@123',
            'email_verified_at' => now(),
            'active' => 1
        ]);
        Person::factory()->create([
            'name' => "Admin",
            'client_id' => null,
            'user_id' => $admin->id,
            'roles' => ["admin"],
            'licensed_id' => null,
        ]);
        foreach ([$licensed->id, $licensed2->id] as $lid) {
            $manager = User::factory()->create([
                'email' => "manager$lid@contabiliza.com.br",
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1,
            ]);
            Person::factory()->create([
                'name' => 'Manager ' . $lid,
                'client_id' => null,
                'user_id' => $manager->id,
                'roles' => ["manager"],
                'licensed_id' => $lid
            ]);

            $consultant = User::factory()->create([
                'email' => 'consultant' . $lid . '@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ]);
            Person::factory()->create([
                'name' => 'Consultant ' . $lid,
                'client_id' => null,
                'user_id' => $consultant->id,
                'roles' => ["consultant"],
                'licensed_id' => $lid,
            ]);
        }

        $client = User::factory()->create([
            'email' => 'client@contabiliza.com.br',
            'password' => 'Senha@123',
            'email_verified_at' => now(),
            'active' => 1
        ]);
        Person::factory()->create([
            'name' => 'Client',
            'client_id' => null,
            'user_id' => $client->id,
            'roles' => ["client"],
            'licensed_id' => $licensed->id,
        ]);
        $agent = User::factory()->create([
            'email' => 'agent@contabiliza.com.br',
            'password' => 'Senha@123',
            'email_verified_at' => now(),
            'active' => 1
        ]);
        $person = Person::factory()->create(['user_id' => $agent->id, 'roles' => ["agent"], 'licensed_id' => $licensed->id, 'client_id' => $client->id]);

        // Cria usuarios consultores
        $consultants = User::factory(5)->create();
        foreach ($consultants as $key => $user) {
            $person = Person::factory()->create(['user_id' => $user->id, 'roles' => ['consultant'], 'licensed_id' => $licensed->id]);
        }

        // Cria usuarios clientes
        $clients = User::factory(5)->create();
        foreach ($clients as $key => $user) {
            $person = Person::factory()->create(['user_id' => $user->id, 'roles' => ["client"], 'licensed_id' => $licensed->id]);
        }
        // Cria usuarios agentes
        $agents = User::factory(5)->create();
        foreach ($agents as $key => $user) {
            $person = Person::factory()->create(['user_id' => $user->id, 'roles' => ["agent"], 'licensed_id' => $licensed->id, 'client_id' => $clients[$key]->id]);
        }

        Empresa::factory(3)->create();

        $rbacSeeder = new RbacSeeder();
        $rbacSeeder->run();

        $planosSeeder = new PlanosSeeder();
        $planosSeeder->run();

        PlanoServicoContratado::factory()->create([
            'empresa_id' => 1,
            'plano' => json_encode(['plano_servico' => 'Bronze',
                'valor' => '100',
                'categorias' => [
                    'Contabilidade' => ['Abertura de empresa gratuita', 'Contabilidade completa'],
                    'Atendimento' => ['Chat e WhatsApp'],
                ],
                'licensed_id' => $licensed->id
            ]),                
        ]);
        PlanoServicoContratado::factory()->create([
            'empresa_id' => 2,
            'plano' => json_encode(['plano_servico' => 'Prata',
                'valor' => '300',
                'categorias' => [
                    'Contabilidade' => ['Abertura de empresa gratuita', 'Contabilidade completa', 'Certificado digital gratuito'],
                    'Atendimento' => ['Chat e WhatsApp', 'Telefone'],
                    'Notas Fiscais' => ['Emissão de notas pelo nosso time'=> 'Até 5 NFs/mês'],
                ],
                'licensed_id' => $licensed->id
            ])
        ]);
        PlanoServicoContratado::factory()->create([
            'empresa_id' => 3,
            'plano' => json_encode(['plano_servico' => 'Ouro',
                'valor' => '500',
                'categorias' => [
                    'Contabilidade' => ['Abertura de empresa gratuita', 'Contabilidade completa', 'Certificado digital gratuito'],
                    'Atendimento' => ['Chat e WhatsApp', 'Telefone', 'Reunião com especialistas'],
                    'Notas Fiscais' => ['Emissão de notas pelo nosso time' => 'Até 10 NFs/mês', 'Emissor de Notas Fiscais'],
                ],
                'licensed_id' => $licensed->id
            ])
        ]);
    }
}
