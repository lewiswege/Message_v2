<?php

namespace App\Messaging\DTOs;

class InboundMessage
{
    public function __construct(
        public readonly string $channelIdentifier,
        public readonly string $content,
        public readonly string $channel,
        public readonly string $provider,

        public readonly ?string $customerName = null,
        public readonly ?string $customerUsername = null,
        
        public readonly ?string $providerMessageId = null,
        public readonly array $metadata = [],
    ) {}
}
