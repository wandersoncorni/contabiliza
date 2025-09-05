<?php

namespace App\Application\Database\Factories;

use App\Application\Models\NaturezaJuridica;
use Illuminate\Database\Eloquent\Factories\Factory;

class NaturezaJuridicaFactory extends Factory
{
    protected $model = NaturezaJuridica::class;

    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->numerify('###-#'),
            'descricao' => $this->faker->company(),
        ];
    }
}
