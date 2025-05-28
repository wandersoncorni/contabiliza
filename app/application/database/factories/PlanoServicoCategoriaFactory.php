<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PlanoServicoCategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_planos_servicos' => 1,
            'id_servicos' => 1,
            'id_categoria' => 1,
        ];
    }
}
