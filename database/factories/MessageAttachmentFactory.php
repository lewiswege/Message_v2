<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'message_id' => Message::factory(),
            'type' => fake()->word(),
            'file_path' => fake()->word(),
            'file_name' => fake()->word(),
            'file_size' => fake()->randomNumber(),
            'mime_type' => fake()->word(),
        ];
    }
}
