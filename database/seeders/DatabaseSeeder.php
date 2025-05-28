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
            'id_client' => null,
            'id_user' => $admin->id,
            'roles' => ["admin"],
            'id_licensed' => null,
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
                'id_client' => null,
                'id_user' => $manager->id,
                'roles' => ["manager"],
                'id_licensed' => $lid
            ]);

            $consultant = User::factory()->create([
                'email' => 'consultant' . $lid . '@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ]);
            Person::factory()->create([
                'name' => 'Consultant ' . $lid,
                'id_client' => null,
                'id_user' => $consultant->id,
                'roles' => ["consultant"],
                'id_licensed' => $lid,
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
            'id_client' => null,
            'id_user' => $client->id,
            'roles' => ["client"],
            'id_licensed' => $licensed->id,
        ]);
        $agent = User::factory()->create([
            'email' => 'agent@contabiliza.com.br',
            'password' => 'Senha@123',
            'email_verified_at' => now(),
            'active' => 1
        ]);
        $person = Person::factory()->create(['id_user' => $agent->id, 'roles' => ["agent"], 'id_licensed' => $licensed->id, 'id_client' => $client->id]);

        // Cria usuarios consultores
        $consultants = User::factory(5)->create();
        foreach ($consultants as $key => $user) {
            $person = Person::factory()->create(['id_user' => $user->id, 'roles' => ['consultant'], 'id_licensed' => $licensed->id]);
        }

        // Cria usuarios clientes
        $clients = User::factory(5)->create();
        foreach ($clients as $key => $user) {
            $person = Person::factory()->create(['id_user' => $user->id, 'roles' => ["client"], 'id_licensed' => $licensed->id]);
        }
        // Cria usuarios agentes
        $agents = User::factory(5)->create();
        foreach ($agents as $key => $user) {
            $person = Person::factory()->create(['id_user' => $user->id, 'roles' => ["agent"], 'id_licensed' => $licensed->id, 'id_client' => $clients[$key]->id]);
        }

        Empresa::factory(3)->create();

        $rbacSeeder = new RbacSeeder();
        $rbacSeeder->run();

        $planosSeeder = new PlanosSeeder();
        $planosSeeder->run();

        PlanoServicoContratado::factory()->create([
            'id_empresa' => 1,
            'plano' => json_encode(['plano_servico' => 'Bronze',
                'valor' => '100',
                'categorias' => [
                    'Contabilidade' => ['Abertura de empresa gratuita', 'Contabilidade completa'],
                    'Atendimento' => ['Chat e WhatsApp'],
                ]
            ])
        ]);
        PlanoServicoContratado::factory()->create([
            'id_empresa' => 2,
            'plano' => json_encode(['plano_servico' => 'Prata',
                'valor' => '300',
                'categorias' => [
                    'Contabilidade' => ['Abertura de empresa gratuita', 'Contabilidade completa', 'Certificado digital gratuito'],
                    'Atendimento' => ['Chat e WhatsApp', 'Telefone'],
                    'Notas Fiscais' => ['Emissão de notas pelo nosso time'=> 'Até 5 NFs/mês'],
                ]
            ])
        ]);
        PlanoServicoContratado::factory()->create([
            'id_empresa' => 3,
            'plano' => json_encode(['plano_servico' => 'Ouro',
                'valor' => '500',
                'categorias' => [
                    'Contabilidade' => ['Abertura de empresa gratuita', 'Contabilidade completa', 'Certificado digital gratuito'],
                    'Atendimento' => ['Chat e WhatsApp', 'Telefone', 'Reunião com especialistas'],
                    'Notas Fiscais' => ['Emissão de notas pelo nosso time' => 'Até 10 NFs/mês', 'Emissor de Notas Fiscais'],
                ]
            ])
        ]);
    }
}
