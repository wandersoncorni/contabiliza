<?php

namespace Database\Seeders;

use App\AccessControl\Models\User;
use App\Application\Models\Pessoa;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();
        foreach ($users as $user) {
            Pessoa::factory()->create(['user_id' => $user->id]);
        }

        $this->call([
            ColaboradorSeeder::class,
        ]);
    }
}
