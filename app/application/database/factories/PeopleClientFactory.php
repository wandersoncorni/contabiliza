<?php

namespace App\Application\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Application\Models\People;
use App\Application\Models\Client;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Application\Models\Model>
 */
class PeopleClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::Factory(),
            'people_id' => People::Factory(),
        ];
    }
}
