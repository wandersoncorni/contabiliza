<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class FaixaFaturamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'regime_tributario_id' => 1, // Simples Nacional
            'licensed_id' => 1, // Licensed ID padrão
            'descricao' => $this->faker->sentence(),
        ];
    }
}
