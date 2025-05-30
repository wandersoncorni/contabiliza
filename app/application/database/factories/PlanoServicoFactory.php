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
            'valor_mensal' => rand(500, 500),
            'valor_anual' => rand(100, 300),
        ];
    }
}
