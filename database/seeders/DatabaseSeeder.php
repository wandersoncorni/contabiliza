<?php

namespace Database\Seeders;

use App\AccessControl\Models\User;
use App\Application\Models\Person;
use App\Application\Models\Licensed;
use App\AccessControl\Database\Seeders\RbacSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        foreach([$licensed->id,$licensed2->id] as $lid){
            $manager = User::factory()->create([
                'email' => "manager$lid@contabiliza.com.br",
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1,
            ]);        
            Person::factory()->create([
                'name' => 'Manager '.$lid,
                'client_id' => null,
                'user_id' => $manager->id, 
                'roles' => ["manager"],
                'licensed_id' => $lid
            ]);

            $consultant = User::factory()->create([
                'email' => 'consultant'.$lid.'@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ]);        
            Person::factory()->create([
                'name' => 'Consultant '. $lid,
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
        foreach ($clients as $key=>$user) {
            $person = Person::factory()->create(['user_id' => $user->id, 'roles' => ["client"], 'licensed_id' => $licensed->id]);
        }
        // Cria usuarios agentes
        $agents = User::factory(5)->create();
        foreach ($agents as $key=>$user) {
            $person = Person::factory()->create(['user_id' => $user->id, 'roles' => ["agent"], 'licensed_id' => $licensed->id, 'client_id' => $clients[$key]->id]);
        }

        $rbacSeeder = new RbacSeeder();
        $rbacSeeder->run();
    }
}
