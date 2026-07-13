<?php

namespace App\Messaging\DTOs;

class ChannelCapabilities
{
    public function __construct(
        public readonly bool $supportsImages,
        public readonly bool $supportsDocuments,
        public readonly bool $supportsButtons,
    ) {}
}
