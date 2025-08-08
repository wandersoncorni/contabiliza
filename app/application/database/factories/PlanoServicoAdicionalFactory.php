<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PlanoServicoAdicionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Adicional Básico',
            'descricao' => 'Descrição do serviço adicional básico',
            'agrupamento_id' => null, // Agrupamento opcional
            'plano_servico_id' => 1,
            'ativo' => true,
            'valor' => 0.00
        ];
    }
}
