<?php

namespace Database\Seeders;

use App\AccessControl\Database\Factories\UserFactory;
use App\Application\Database\Factories\PersonFactory;
use App\AccessControl\Database\Seeders\RbacSeeder;
use App\Application\Database\Factories\LicensedFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $licensed = LicensedFactory::new()->create([
            'name' => 'Contabiliza',
        ]);
        $licensed2 = LicensedFactory::new()->create([
            'name' => 'licensed 2',
        ]);
        
        // Cria um admininistrador validado
            $admin = UserFactory::new()->create([
                'email' => "admin@contabiliza.com.br",
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ]);        
            PersonFactory::new()->create([
                'name' => "Admin",
                'client_id' => null,
                'user_id' => $admin->id, 
                'roles' => ["admin"],
                'licensed_id' => null,
            ]);
        foreach([$licensed->id,$licensed2->id] as $lid){
            $manager = UserFactory::new()->create([
                'email' => "manager$lid@contabiliza.com.br",
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1,
            ]);        
            PersonFactory::new()->create([
                'name' => 'Manager '.$lid,
                'client_id' => null,
                'user_id' => $manager->id, 
                'roles' => ["manager"],
                'licensed_id' => $lid
            ]);

            $consultant = UserFactory::new()->create([
                'email' => 'consultant'.$lid.'@contabiliza.com.br',
                'password' => 'Senha@123',
                'email_verified_at' => now(),
                'active' => 1
            ]);        
            PersonFactory::new()->create([
                'name' => 'Consultant '. $lid,
                'client_id' => null,
                'user_id' => $consultant->id, 
                'roles' => ["consultant"],
                'licensed_id' => $lid,
            ]);
        }
        
        $client = UserFactory::new()->create([
            'email' => 'client@contabiliza.com.br',
            'password' => 'Senha@123',
            'email_verified_at' => now(),
            'active' => 1
        ]);        
        PersonFactory::new()->create([
            'name' => 'Client',
            'client_id' => null,
            'user_id' => $client->id, 
            'roles' => ["client"],
            'licensed_id' => $licensed->id,
        ]);
        $agent = UserFactory::new()->create([
            'email' => 'agent@contabiliza.com.br',
            'password' => 'Senha@123',
            'email_verified_at' => now(),
            'active' => 1
        ]);
        $person = PersonFactory::new()->create(['user_id' => $agent->id, 'roles' => ["agent"], 'licensed_id' => $licensed->id, 'client_id' => $client->id]);

        // Cria usuarios consultores
        $consultants = UserFactory::new(5)->create();
        foreach ($consultants as $key => $user) {
            $person = PersonFactory::new()->create(['user_id' => $user->id, 'roles' => ['consultant'], 'licensed_id' => $licensed->id]);
        }

        // Cria usuarios clientes
        $clients = UserFactory::new(5)->create();
        foreach ($clients as $key=>$user) {
            $person = PersonFactory::new()->create(['user_id' => $user->id, 'roles' => ["client"], 'licensed_id' => $licensed->id]);
        }
        // Cria usuarios agentes
        $agents = UserFactory::new(5)->create();
        foreach ($agents as $key=>$user) {
            $person = PersonFactory::new()->create(['user_id' => $user->id, 'roles' => ["agent"], 'licensed_id' => $licensed->id, 'client_id' => $clients[$key]->id]);
        }

        $rbacSeeder = new RbacSeeder();
        $rbacSeeder->run();
    }
}
