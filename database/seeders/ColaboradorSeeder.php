<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\AccessControl\Models\User;
use App\Application\Models\Pessoa;
use App\Application\Models\Associado;
use Illuminate\Support\Facades\DB;

class ColaboradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = DB::table('pessoas')->where('roles', 'like', '%client%')->get();
        foreach ($clientes as $cliente) {
            $user = User::factory()->create();        
            $pessoa = Pessoa::factory()->create([
                'user_id' => $user->id,
                'roles' => '["associated"]',
            ]);
            Associado::factory()->create([
                'client_id' => $cliente->id,
                'associated_id' => $pessoa->id,
            ]);
        }        
    }
}
