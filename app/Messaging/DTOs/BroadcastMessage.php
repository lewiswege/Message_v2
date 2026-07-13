<?php

namespace App\Messaging\DTOs;

class BroadcastMessage
{
    public function __construct(
        public readonly string $id,
        public readonly string $conversationId,
        public readonly string $direction,
        public readonly string $channel,
        public readonly string $content,
        public readonly string $createdAt,
    ) {
    }
}
