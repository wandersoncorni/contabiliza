<?php

namespace Database\Seeders;

use App\AccessControl\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['parent_id' => 0, 'name' => 'Administrator','label' => 'admin']);
        Role::create(['parent_id' => 1, 'name' => 'Gerente', 'label' => 'manager']);
        Role::create(['parent_id' => 2, 'name' => 'Consultor', 'label' => 'consultant']);
        Role::create(['parent_id' => 2, 'name' => 'Cliente', 'label' => 'client']);
        Role::create(['parent_id' => 1, 'name' => 'Usuário', 'label' => 'user']);
    }
}
