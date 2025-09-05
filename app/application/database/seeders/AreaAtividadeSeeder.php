<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\AreaAtividade;

class AreaAtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AreaAtividade::factory()->create([
            'descricao' => 'Comércio',
        ]);
        AreaAtividade::factory()->create([
            'descricao' => 'Serviço',
        ]);
        AreaAtividade::factory()->create([
            'descricao' => 'Comércio e Serviço',
        ]);
    }
};
