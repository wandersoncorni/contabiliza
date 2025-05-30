<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'client_ide' => 1,
            'nome' => $faker->company,
            'cnpj' => $this->generateFakeCnpj()
        ];
    }

    private function generateFakeCnpj(): string
    {
        $n = array_map(fn() => rand(0, 9), range(1, 12));

        $d1 = 11 - ((
            $n[0]*5 + $n[1]*4 + $n[2]*3 + $n[3]*2 + $n[4]*9 +
            $n[5]*8 + $n[6]*7 + $n[7]*6 + $n[8]*5 + $n[9]*4 +
            $n[10]*3 + $n[11]*2
        ) % 11);
        $d1 = $d1 >= 10 ? 0 : $d1;

        $d2 = 11 - ((
            $n[0]*6 + $n[1]*5 + $n[2]*4 + $n[3]*3 + $n[4]*2 +
            $n[5]*9 + $n[6]*8 + $n[7]*7 + $n[8]*6 + $n[9]*5 +
            $n[10]*4 + $n[11]*3 + $d1*2
        ) % 11);
        $d2 = $d2 >= 10 ? 0 : $d2;

        return implode('', $n) . $d1 . $d2;
    }
}
