<?php

namespace App\Application\Database\Factories;

use App\Application\Models\PlanoServico;
use App\Application\Models\FaixaFaturamento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PlanoServicoFaixaFaturamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plano_servico_id' => PlanoServico::factory(), // ID do plano de serviço padrão
            'faixa_faturamento_id' => FaixaFaturamento::factory(), // ID da faixa de fatur
            'valor' => $this->faker->randomFloat(2, 100, 10000), // Valor aleatório entre 100 e 10.000
            'ativo' => true, // Ativo por padrão
            'created_at' => now(),
        ];
    }
}
