<?php

namespace App\Messaging\DTOs;

class ChannelResponse
{
    public function __construct(
        public readonly bool $success,
        public mixed $rawResponse,
        public readonly ?string $providerMessageId = null,
        public readonly ?string $error = null,
    ) {}
}
