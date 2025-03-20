<?php

namespace Database\Seeders;

use App\AccessControl\Models\User;
use App\Application\Models\People;
use App\Application\Models\Licenciado;
use App\Application\Models\Client;
use App\Application\Models\PeopleClient;
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
        Licenciado::factory()->create();        
        // Cria um admininistrador validado
        $user = User::factory(1)->create();
        People::factory()->create(['user_id' => $user[0]->id, 'roles' => '["admin"]']);
        $userObj = User::find($user[0]->id);
        $userObj->email_verified_at = now();
        $userObj->active = 1;
        $userObj->save();

        $users = User::factory(5)->create();
        $clients = Client::factory(5)->create();
        foreach ($users as $key=>$user) {
            $pid = People::factory()->create(['user_id' => $user->id, 'roles' => '["client"]']);
            PeopleClient::factory()->create(['client_id' => $clients[$key], 'people_id' => $pid]);
        }

        $users = User::factory(5)->create();
        foreach ($users as $key=>$user) {
            $pid = People::factory()->create(['user_id' => $user->id, 'roles' => '["agent"]']);
            PeopleClient::factory()->create(['client_id' => $clients[$key], 'people_id' => $pid]);
        }

        $users = User::factory(5)->create();
        foreach ($users as $key => $user) {
            $roles = ['manager', 'consultant'];
            People::factory()->create(['user_id' => $user->id, 'roles' => '["'.($roles[$key%2]).'"]']);
        }

        $rbacSeeder = new RbacSeeder();
        $rbacSeeder->run();
    }
}
