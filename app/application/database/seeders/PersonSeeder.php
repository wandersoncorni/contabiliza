<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\Person;
use App\AccessControl\Models\User;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $data = [
            [
                'name' => "Admin",
                'client_id' => null,
                'user_id' => 1, // Assuming admin user ID is 1
                'roles' => ["admin"],
                'licensed_id' => null,
            ],
            [
                'name' => 'Manager 1',
                'client_id' => null,
                'user_id' => 2, // Assuming manager user ID is 2
                'roles' => ["manager"],
                'licensed_id' => 1, // Assuming licensed ID is 1
            ],
            [
                'name' => 'Consultant 1',
                'client_id' => null,
                'user_id' => 3, // Assuming consultant user ID is 3
                'roles' => ["consultant"],
                'licensed_id' => 1, // Assuming licensed ID is 1
            ],
            [
                'name' => 'Client 1',
                'client_id' => null,
                'user_id' => 4,
                'roles' => ["client"],
                'licensed_id' => 1,
            ],
            [
                'name' => 'Agent 1',
                'client_id' => 4,
                'user_id' => 5, // Assuming agent user ID is 5
                'roles' => ["agent"],
                'licensed_id' => 1, // Assuming licensed ID is 1
            ],
            [
                'name' => 'Client 2',
                'client_id' => null,
                'user_id' => 6,
                'roles' => ["client"],
                'licensed_id' => 2,
            ],
        ];

        foreach ($data as $item) {
            Person::factory()->create($item);
        }
    }
}
