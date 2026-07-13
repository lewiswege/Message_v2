<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\ReplyToMessage;
use App\Models\SentByAgent;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'direction' => fake()->word(),
            'channel' => fake()->word(),
            'provider' => fake()->word(),
            'channel_message_id' => fake()->word(),
            'reply_to_message_id' => ReplyToMessage::factory(),
            'content_type' => fake()->word(),
            'content' => fake()->paragraphs(3, true),
            'metadata' => '{}',
            'status' => fake()->word(),
            'status_updated_at' => fake()->dateTime(),
            'failure_reason' => fake()->text(),
            'sent_by_agent_id' => SentByAgent::factory(),
        ];
    }
}
