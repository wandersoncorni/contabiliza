<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\FaixaFaturamento;
use App\Application\Models\PlanoServicoFaixaFaturamento;

class FaixaFaturamentoSeeder extends Seeder
{
    public function run(): void
    {
        $faixasFaturamento = [
            //Simples Nacional
            1 => [
                'Até R$ 30.000,00',
                'De R$ 30.000,01 até R$ 50.000,00',
                'De R$ 50.000,01 até R$ 100.000,00',
                'De R$ 100.000,01 até R$ 150.000,00',
                'De R$ 150.000,01 até R$ 200.000,00',
                'De R$ 200.000,01 até R$ 300.000,00',
                'De R$ 300.000,01 até R$ 500.000,00',
                'De R$ 500.000,01 até R$ 1.000.000,00',
                'Acima de R$ 1.000.000,01',
            ],
            //Lucro Presumido
            2 => [
                'Até R$ 30.000,00',
                'De R$ 30.000,01 até R$ 50.000,00',
                'De R$ 50.000,01 até R$ 100.000,00',
                'De R$ 100.000,01 até R$ 150.000,00',
                'De R$ 150.000,01 até R$ 200.000,00',
                'De R$ 200.000,01 até R$ 300.000,00',
            ],
        ];
        foreach ($faixasFaturamento as $regimeId => $faixas) {
            foreach ($faixas as $findex => $descricao) {
                $fid = FaixaFaturamento::factory()->create([
                    'regime_tributario_id' => $regimeId,
                    'licensed_id' => 1,
                    'descricao' => $descricao,
                    'created_at' => now(),
                    'ativo' => true,
                ])->id;
            }
        }
    }
}
