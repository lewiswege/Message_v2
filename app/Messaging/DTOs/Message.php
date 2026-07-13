<?php

namespace App\Messaging\DTOs;

class Message
{
    public function __construct(
        public readonly string $recipient,
        public readonly string $content,
        public readonly string $channel,
        public readonly string $provider,
        // public readonly string $channelMessaheId,
        // public readonly string $contentType, // for media support later
        public readonly array $metadata = [],
    ) {
    }
}
