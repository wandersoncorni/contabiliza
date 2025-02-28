<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\AccessControl\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'Criar', 'label' => 'create']);
        Permission::create(['name' => 'Ler', 'label' => 'read']);
        Permission::create(['name' => 'Editar', 'label' => 'update']);
        Permission::create(['name' => 'Excluir', 'label' => 'delete']);
    }
}
