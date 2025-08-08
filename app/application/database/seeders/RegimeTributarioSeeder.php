<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\RegimeTributario;

class RegimeTributarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegimeTributario::factory()->create([
            'descricao' => 'Simples Nacional',
        ]);
        RegimeTributario::factory()->create([
            'descricao' => 'Lucro Presumido',
        ]);
    }
};
