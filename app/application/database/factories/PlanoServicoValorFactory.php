<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PlanoServicoValorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'licensed_id' => 1,
            'plano_servico_id' => 1,
            'area_atividade_id' => 1, // 1 - Comércio
            'ativo' => true,
            'valor' => 0.00,
            'rotulo' => 'Mensal',
        ];
    }
}
