<?php

namespace Database\Factories;

use App\Models\AssignedAgent;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'status' => fake()->word(),
            'assigned_agent_id' => AssignedAgent::factory(),
            'last_message_at' => fake()->dateTime(),
            'last_inbound_channel' => fake()->word(),
            'unread_count' => fake()->randomNumber(),
            'resolved_at' => fake()->dateTime(),
        ];
    }
}
