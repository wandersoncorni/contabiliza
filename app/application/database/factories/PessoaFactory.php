<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AccessControl\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = array_keys(Config('rbac.roles'));
        $roles = array_filter($roles, fn($role) => $role !== 'root');
        $roles = array_filter($roles, fn($role) => $role !== 'associated');
        $roles = array_merge($roles, ['client', 'client']);

        return [
            'user_id' => User::Factory(),
            'nome' => $this->faker->name(),
            'telefone' => $this->faker->phoneNumber(),
            'roles' => '["'.$this->faker->randomElement($roles).'"]',
        ];
    }
}
