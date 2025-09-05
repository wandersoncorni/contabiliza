<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\NaturezaJuridica;

class NaturezaJuridicaSeeder extends Seeder
{
    public function run(): void
    {
        $dados = [
            ['codigo' => '204-6', 'descricao' => 'Sociedade Anônima Aberta'],
            ['codigo' => '205-4', 'descricao' => 'Sociedade Anônima Fechada'],
            ['codigo' => '206-2', 'descricao' => 'Sociedade Limitada (LTDA)'],
            ['codigo' => '213-5', 'descricao' => 'Microempreendedor Individual (MEI)'],
            ['codigo' => '213-5', 'descricao' => 'Empresário Individual (EI)'],
            ['codigo' => '215-1', 'descricao' => 'Consórcio de Sociedades'],
            ['codigo' => '234-8', 'descricao' => 'Inova Simples (IS)'],
            ['codigo' => '303-8', 'descricao' => 'Trabalhador Autônomo / Profissional Liberal (com CNPJ)'],
        ];

        NaturezaJuridica::insert($dados);
    }
}
