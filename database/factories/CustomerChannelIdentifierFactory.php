<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerChannelIdentifierFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'channel' => fake()->word(),
            'provider' => fake()->word(),
            'identifier' => fake()->word(),
            'verified_at' => fake()->dateTime(),
            'metadata' => '{}',
        ];
    }
}
