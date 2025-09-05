<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PlanoServicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Plano Básico',
            'descricao' => 'Plano básico com funcionalidades limitadas',
            'licensed_id' => 1,
            'cor' => '#ff0000',
            'posicao' => 1
        ];
    }
}
