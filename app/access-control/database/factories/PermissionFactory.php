<?php

namespace App\AccessControl\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\AccessControl\Models\Model>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => null,
            'asset_id' => null,
            'action_id' => null,
        ];
    }
}
