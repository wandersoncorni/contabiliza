<?php

namespace App\AccessControl\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AccessControl\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Senha@123',
            'email_verified_at' => null,
            'remember_token' => null,
            'active' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function newModel(array $attributes = [])
    {
        return new User($attributes);
    }
}
