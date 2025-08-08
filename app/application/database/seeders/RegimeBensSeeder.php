<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\RegimeBens;

class RegimeBensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regimesBens = [
            'Comunhão Parcial de Bens',
            'Comunhão Universal de Bens',
            'Separação Total de Bens',
            'Participação Final nos Aquestos',
            'Outros',
        ];
        foreach ($regimesBens as $regimeBens) {
            RegimeBens::factory()->create([
                'nome' => $regimeBens
            ]);
        }
    }
};