<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PlanoServicoAdicionaisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plano_servico_id' => 1,
            'plano_servico_adicional_id' => 1,
            'created_at' => now(),
            'ativo' => true,
            'valor_mensal' => 0.00,
            'valor_anual' => 0.00
        ];
    }
}
