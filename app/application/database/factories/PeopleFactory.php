<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AccessControl\Models\User;
use App\AccessControl\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PeopleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = Role::all()->pluck('label')->toArray();
        $roles = array_filter($roles, fn($role) => $role !== 'root');
        $roles = array_filter($roles, fn($role) => $role !== 'associated');
        
        $roles = array_merge($roles, ['client', 'client']);

        return [
            'user_id' => User::Factory(),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'roles' => User::Factory() ?? '["'.$this->faker->randomElement($roles).'"]',
            'licenciado_id' => 1
        ];
    }
}
